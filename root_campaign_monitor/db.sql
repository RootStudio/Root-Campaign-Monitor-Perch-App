DROP TABLE IF EXISTS `__PREFIX__root_campaign_monitor_campaigns`;

CREATE TABLE `__PREFIX__root_campaign_monitor_campaigns` (
  `campaignID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `campaignMonitorID` char(255) NOT NULL,
  `campaignDateScheduled` datetime DEFAULT NULL,
  `campaignStatus` enum('Sent','Scheduled','Draft') DEFAULT NULL,
  `campaignSubject` varchar(255) NOT NULL DEFAULT '',
  `campaignName` varchar(255) NOT NULL DEFAULT '',
  `campaignPreviewURL` text,
  `campaignBounces` int(10) unsigned NOT NULL DEFAULT '0',
  `campaignOpened` int(10) unsigned NOT NULL DEFAULT '0',
  `campaignClicks` int(10) unsigned NOT NULL DEFAULT '0',
  `campaignRecipients` int(10) unsigned NOT NULL DEFAULT '0',
  `campaignUnsubscribed` int(10) unsigned NOT NULL DEFAULT '0',
  `campaignCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `campaignUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`campaignID`),
  UNIQUE KEY (`campaignMonitorID`),
  FULLTEXT KEY (`campaignSubject`)
) ENGINE=MyISAM CHARSET=utf8;

DROP TABLE IF EXISTS `__PREFIX__root_campaign_monitor_lists`;

CREATE TABLE `__PREFIX__root_campaign_monitor_lists` (
  `listID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `listCampaignMonitorID` char(255) NOT NULL,
  `listTitle` char(255) NOT NULL DEFAULT '',
  `listTotalActiveSubscribers` int(10) unsigned NOT NULL DEFAULT '0',
  `listTotalUnsubscribes` int(10) unsigned NOT NULL DEFAULT '0',
  `listTotalDeleted` int(10) unsigned NOT NULL DEFAULT '0',
  `listTotalBounces` int(10) unsigned NOT NULL DEFAULT '0',
  `listConfirmedOptIn` tinyint(1) unsigned DEFAULT '1',
  `listCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `listUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`listID`),
  UNIQUE KEY (`listCampaignMonitorID`)
) CHARSET=utf8;

DROP TABLE IF EXISTS `__PREFIX__root_campaign_monitor_imports`;

CREATE TABLE `__PREFIX__root_campaign_monitor_imports` (
  `importID` int(10) NOT NULL AUTO_INCREMENT,
  `importType` varchar(32) NOT NULL,
  `importValue` varchar(32) NULL DEFAULT 'false',
  `importUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`importID`)
) CHARSET=utf8;

DROP TABLE IF EXISTS `__PREFIX__root_campaign_monitor_subscribers`;

CREATE TABLE `__PREFIX__root_campaign_monitor_subscribers` (
  `subscriberID` int(11) NOT NULL AUTO_INCREMENT,
  `listCampaignMonitorID` char(255) NOT NULL,
  `subscriberEmailAddress` char(255) NOT NULL DEFAULT '',
  `subscriberName` char(255) DEFAULT NULL,
  `subscriberState` char(255) NOT NULL,
  `subscriberDateSubscribed` date NULL,
  `subscriberCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `subscriberUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`subscriberID`),
  UNIQUE KEY (`subscriberEmailAddress`)
) CHARSET=utf8;