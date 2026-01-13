<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.com)
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\SysInfo\Command\LicenceService;

use Armah\Base\Model\LicenceService\Schedule\ScheduleConfigRepository;
use Armah\Base\Model\SysInfo\Command\LicenceService\ProcessLicenseRegistrationResponse\DefaultResponseProvider;
use Armah\Base\Model\SysInfo\Data\LicenseValidation;
use Armah\Base\Model\SysInfo\Data\LicenseValidationFactory;
use Armah\Base\Model\SysInfo\LicenseValidationRepository;
use Magento\Framework\Stdlib\DateTime\DateTime;

class GetCurrentLicenseValidation
{
    public const TIME_INTERVAL = 604800; //7 days

    /**
     * @var ProcessLicenseValidationResponse
     */
    private $processLicenseValidationResponse;

    /**
     * @var LicenseValidationRepository
     */
    private $licenseValidationRepository;

    /**
     * @var ScheduleConfigRepository
     */
    private $scheduleConfigRepository;

    /**
     * @var DefaultResponseProvider
     */
    private $defaultResponseProvider;

    /**
     * @var LicenseValidationFactory
     */
    private $licenseValidationFactory;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var LicenseValidation
     */
    private $currentLicense;

    public function __construct(
        ProcessLicenseValidationResponse $processLicenseValidationResponse,
        LicenseValidationRepository $licenseValidationRepository,
        ScheduleConfigRepository $scheduleConfigRepository,
        DefaultResponseProvider $defaultResponseProvider,
        LicenseValidationFactory $licenseValidationFactory,
        DateTime $dateTime
    ) {
        $this->processLicenseValidationResponse = $processLicenseValidationResponse;
        $this->licenseValidationRepository = $licenseValidationRepository;
        $this->scheduleConfigRepository = $scheduleConfigRepository;
        $this->defaultResponseProvider = $defaultResponseProvider;
        $this->licenseValidationFactory = $licenseValidationFactory;
        $this->dateTime = $dateTime;
    }

    public function get(): LicenseValidation
    {
        if (!$this->currentLicense) {
            $this->currentLicense = $this->prepareCurrentLicense();
        }

        return $this->currentLicense;
    }

    private function prepareCurrentLicense(): LicenseValidation
    {
        try {
            $scheduleConfig = $this->scheduleConfigRepository->get(ProcessLicenseValidationResponse::FLAG_NAME);
        } catch (\InvalidArgumentException $exception) {
            $licenseValidation = $this->licenseValidationFactory->create();
            $licenseValidation->setIsNeedCheckLicense(false);

            return $licenseValidation;
        }

        $currentLicense = $this->licenseValidationRepository->get();
        if ($currentLicense->isNeedCheckLicense() !== true) {
            return $currentLicense;
        }

        $currentTime = $this->dateTime->gmtTimestamp();
        $isValid = $currentTime < $scheduleConfig->getLastSendDate() + self::TIME_INTERVAL;
        if (!$isValid) {
            $this->processLicenseValidationResponse->process(
                $this->defaultResponseProvider->getVerificationProcessError()
            );
        }

        return $this->licenseValidationRepository->get();
    }
}
