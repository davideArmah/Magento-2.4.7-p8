# Migrazione Automatica da Amasty a Armah

## Come Funziona

Quando installi i moduli Armah su un sito che ha già Amasty installato, la migrazione delle tabelle del database avviene **automaticamente**.

## Processo Automatico

### 1. **Installazione Nuova (Sito Pulito)**
Se installi Armah su un sito nuovo senza Amasty:
```bash
composer require armah/module-base armah/module-shopby # etc.
bin/magento setup:upgrade
```

**Risultato:**
- ✅ Crea direttamente le tabelle `armah_*`
- ✅ Nessuna migrazione necessaria
- ✅ Tutto funziona immediatamente

### 2. **Migrazione (Sito con Amasty Esistente)**
Se installi Armah su un sito che ha già Amasty:
```bash
composer require armah/module-base armah/module-shopby # etc.
bin/magento setup:upgrade
```

**Risultato:**
- ✅ Rileva automaticamente le tabelle `amasty_*` esistenti
- ✅ Le rinomina automaticamente a `armah_*`
- ✅ Mantiene tutti i dati esistenti
- ✅ Nessuna perdita di dati
- ✅ Nessun intervento manuale richiesto

## Data Patch Automatico

Il file `Setup/Patch/Data/MigrateAmastyTablesToArmah.php` nel modulo `Armah_Base`:

1. **Si esegue automaticamente** durante `setup:upgrade`
2. **Controlla** se esistono tabelle `amasty_*`
3. **Se trova tabelle Amasty:**
   - Disabilita i foreign key checks
   - Rinomina ogni tabella da `amasty_*` a `armah_*`
   - Riabilita i foreign key checks
   - Logga ogni operazione
4. **Se NON trova tabelle Amasty:**
   - Salta la migrazione
   - Continua con l'installazione normale

## Sicurezza

### Protezioni Integrate:
- ✅ Controlla se la tabella di destinazione esiste già (evita sovrascritture)
- ✅ Usa transazioni per operazioni atomiche
- ✅ Disabilita temporaneamente i foreign key per evitare errori
- ✅ Logga ogni operazione per debugging
- ✅ Gestisce errori senza bloccare l'installazione

### Log:
Tutti i messaggi vengono loggati in:
```
var/log/system.log
var/log/debug.log
```

Cerca linee come:
```
Found 234 Amasty tables to migrate
Migrated: amasty_blog_posts → armah_blog_posts
Amasty to Armah table migration completed successfully
```

## Esempio Completo

### Scenario: Sito con Amasty → Migrazione ad Armah

```bash
# 1. Backup (sempre consigliato!)
mysqldump -u root -p magento_db > backup_before_armah.sql

# 2. Installazione moduli Armah
composer require armah/module-base
composer require armah/module-shopby
composer require armah/module-blog
# ... altri moduli

# 3. Esegui upgrade (la migrazione avviene qui automaticamente)
bin/magento setup:upgrade

# Output atteso:
# [INFO] Found 234 Amasty tables to migrate
# [INFO] Migrated: amasty_shopby_filter_setting → armah_shopby_filter_setting
# [INFO] Migrated: amasty_blog_posts → armah_blog_posts
# ... (continua per tutte le tabelle)
# [INFO] Amasty to Armah table migration completed successfully

# 4. Verifica
bin/magento setup:db:status
# Should show: Up to Date

# 5. Cache flush
bin/magento cache:flush

# 6. Deploy (production)
bin/magento setup:static-content:deploy it_IT en_US -f
bin/magento deploy:mode:set production
```

## Verifica Post-Migrazione

### Database:
```sql
-- Verifica che non ci siano più tabelle Amasty
SELECT COUNT(*) FROM information_schema.TABLES
WHERE TABLE_SCHEMA = 'magento' AND TABLE_NAME LIKE 'amasty_%';
-- Risultato atteso: 0

-- Verifica le tabelle Armah
SELECT COUNT(*) FROM information_schema.TABLES
WHERE TABLE_SCHEMA = 'magento' AND TABLE_NAME LIKE 'armah_%';
-- Risultato atteso: ~234 (o il numero corrispondente)
```

### Dati:
```sql
-- Esempio: Verifica i dati nei blog post
SELECT COUNT(*) FROM armah_blog_posts;
-- Dovrebbe mostrare lo stesso numero di post che avevi in Amasty
```

## Rollback (Se Necessario)

Se qualcosa va storto durante la migrazione:

```bash
# 1. Ripristina il backup
mysql -u root -p magento_db < backup_before_armah.sql

# 2. Rimuovi i moduli Armah
composer remove armah/module-base armah/module-shopby # etc.

# 3. Setup upgrade
bin/magento setup:upgrade
```

## FAQ

### Q: La migrazione è reversibile?
**A:** Sì, se hai un backup. La migrazione rinomina le tabelle ma non le cancella, quindi con un backup puoi sempre tornare indietro.

### Q: Cosa succede ai dati esistenti?
**A:** Vengono mantenuti al 100%. Il comando `RENAME TABLE` sposta la tabella mantenendo tutti i dati, indici, e foreign keys.

### Q: Posso eseguire la migrazione manualmente?
**A:** No, è automatica. Se però vuoi testare il processo, puoi:
1. Marcare il patch come non eseguito
2. Eseguire `setup:upgrade` di nuovo

```sql
DELETE FROM patch_list WHERE patch_name = 'Armah\\Base\\Setup\\Patch\\Data\\MigrateAmastyTablesToArmah';
```

### Q: Quanto tempo richiede?
**A:** Dipende dal numero di tabelle. In genere:
- 50 tabelle: ~5-10 secondi
- 234 tabelle: ~30-60 secondi

### Q: Funziona con tutte le versioni di Magento?
**A:** Sì, funziona con Magento 2.3.x e 2.4.x.

## Supporto

Per problemi o domande:
- Email: support@armah.com
- GitHub Issues: https://github.com/armah-ecommerce-agency
