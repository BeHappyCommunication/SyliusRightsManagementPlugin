<?php

declare(strict_types = 1);

namespace BeHappy\SyliusRightsManagementPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;

/**
 * Class NotificationContext
 *
 * @package BeHappy\SyliusRightsManagementPlugin\Behat\Context\Ui\Admin
 */
final class NotificationContext implements Context
{
    /** @var NotificationCheckerInterface */
    private $notificationChecker;
    
    /**
     * NotificationContext constructor.
     *
     * @param NotificationCheckerInterface $notificationChecker
     */
    public function __construct(NotificationCheckerInterface $notificationChecker)
    {
        $this->notificationChecker = $notificationChecker;
    }
    
    public function iShouldBeNotifiedItHasBeenSuccessfullyCreated(): void
    {
        $this->notificationChecker->checkNotification('has been successfully created.', NotificationType::success());
    }
}