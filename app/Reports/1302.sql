/**
applicationActive = 1;
applicationPassive = 2;
applicationTerminated = 3;
contentDownloaded = 10;
contentUpdated = 11;
contentOpened = 12;
contentClosed = 13;
contentDeleted = 14;
pageOpenedPortrait = 21;
pageOpenedLandscape = 22;
 */

SELECT
	`CustomerNo`, 
	`CustomerName`,
	`ApplicationName`,
	`ContentName`,
	`Country`,
	`City`, 
	`District`, 
	`Page`, 
	SUM(`Duration`) AS `Duration`,
	COUNT(DISTINCT `DeviceID`) AS `People`
FROM (
	SELECT 
		cu.`CustomerID`, cu.`CustomerNo`, cu.`CustomerName`, cu.`DateCreated`,
		ap.`ApplicationID`, ap.`Name` AS `ApplicationName`, ap.`ExpirationDate`,
		cn.`ContentID`,
		cn.`Name` AS `ContentName`,
		IFNULL(st.`Country`, '') AS `Country`,
		IFNULL(st.`City`, '') AS `City`,
		IFNULL(st.`District`, '') AS `District`,
    IFNULL(st.`Lat`, '') AS `Lat`,
    IFNULL(st.`Long`, '') AS `Long`,
    IFNULL(st.`Page`, 0) AS `Page`,
    IFNULL(st.`DeviceID`, '') AS `DeviceID`,
		getDuration2(st.`CustomerID`, st.`ApplicationID`, st.`ContentID`, st.`DeviceID`, st.`Type`, st.`Page`, st.`Time`) AS `Duration`
	FROM `Customer` cu
		INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
		INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
		INNER JOIN `Statistic` st ON st.`CustomerID`=cu.`CustomerID` AND st.`ApplicationID`=ap.`ApplicationID` AND st.`ContentID`=cn.`ContentID`
		 AND (st.`Type`='21' OR st.`Type`='22') AND st.`Time` BETWEEN '{SD}' AND '{ED}' AND (st.`Country`={COUNTRY} OR {COUNTRY} IS NULL)
		 AND (st.`City`={CITY} OR {CITY} IS NULL) AND (st.`District`={DISTRICT} OR {DISTRICT} IS NULL)
	WHERE 
		cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
		ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
		cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) AND 
		cu.`StatusID`=1
) t 
GROUP BY `CustomerNo`, `CustomerName`, `ApplicationName`, `ContentName`, `Country`, `City`, `District`, `Page`
ORDER BY `CustomerNo`, `CustomerName`, `ApplicationName`, `ContentName`, `Country`, `City`, `District`, `Page`
