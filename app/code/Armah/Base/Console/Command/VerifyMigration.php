<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.com)
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Console\Command;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Console\Cli;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File as FileDriver;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Verify Armah to Armah migration status
 */
class VerifyMigration extends Command
{
    /**
     * @var Filesystem
     */
    private $filesystem;
    
    /**
     * @var FileDriver
     */
    private $fileDriver;
    
    public function __construct(
        Filesystem $filesystem,
        FileDriver $fileDriver,
        string $name = null
    ) {
        $this->filesystem = $filesystem;
        $this->fileDriver = $fileDriver;
        parent::__construct($name);
    }
    
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('armah:migration:verify')
            ->setDescription('Verify Armah to Armah migration status');
        
        parent::configure();
    }
    
    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>═══════════════════════════════════════════</info>');
        $output->writeln('<info>  Armah Migration Verification Report</info>');
        $output->writeln('<info>═══════════════════════════════════════════</info>');
        $output->writeln('');
        
        $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $mediaPath = $mediaDirectory->getAbsolutePath();
        
        $amastyPath = $mediaPath . 'amasty';
        $armahPath = $mediaPath . 'armah';
        
        // Check armah directory
        $output->write('<comment>1. Checking pub/media/amasty...</comment> ');
        if ($this->fileDriver->isDirectory($amastyPath)) {
            $output->writeln('<error>❌ STILL EXISTS</error>');
            $output->writeln('   <comment>Action needed: Run setup:upgrade or manually move to pub/media/armah</comment>');
        } else {
            $output->writeln('<info>✅ NOT EXISTS (Good)</info>');
        }
        
        // Check armah directory
        $output->write('<comment>2. Checking pub/media/armah...</comment> ');
        if ($this->fileDriver->isDirectory($armahPath)) {
            $output->writeln('<info>✅ EXISTS (Good)</info>');
            
            // Count subdirectories
            try {
                $subdirs = [];
                $items = $this->fileDriver->readDirectory($armahPath);
                foreach ($items as $item) {
                    if ($this->fileDriver->isDirectory($item)) {
                        $subdirs[] = basename($item);
                    }
                }
                $output->writeln('   <info>Subdirectories: ' . implode(', ', $subdirs) . '</info>');
            } catch (\Exception $e) {
                $output->writeln('   <comment>Could not read subdirectories</comment>');
            }
        } else {
            $output->writeln('<error>❌ NOT EXISTS</error>');
            $output->writeln('   <comment>Action needed: Check if media files need migration</comment>');
        }
        
        $output->writeln('');
        
        // Check code references
        $output->writeln('<comment>3. Checking code references...</comment>');
        
        $codeChecks = [
            'Blog media path' => 'app/code/Armah/Blog/Model/ImageProcessor.php',
            'Banners media path' => 'app/code/Armah/BannersLite/Model/ImageProcessor.php',
            'Migration script' => 'app/code/Armah/Base/Setup/Patch/Data/MigrateAmastyMediaDirectories.php'
        ];
        
        foreach ($codeChecks as $check => $file) {
            $output->write('   ' . $check . '... ');
            if (file_exists(BP . '/'. $file)) {
                $output->writeln('<info>✅</info>');
            } else {
                $output->writeln('<error>❌</error>');
            }
        }
        
        $output->writeln('');
        $output->writeln('<info>═══════════════════════════════════════════</info>');
        $output->writeln('<info>  Verification Complete</info>');
        $output->writeln('<info>═══════════════════════════════════════════</info>');
        
        return Cli::RETURN_SUCCESS;
    }
}
