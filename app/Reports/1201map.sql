SELECT DISTINCT `Lat`, `Long`, `Country`
FROM (
	SELECT 
		cu.`CustomerID`, cu.`CustomerNo`, cu.`CustomerName`, cu.`DateCreated`,
		ap.`ApplicationID`, ap.`Name` AS `ApplicationName`, ap.`ExpirationDate`, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=ap.`ApplicationStatusID` AND `LanguageID`=1) AS `ApplicationStatusName`, IFNULL(ap.`Blocked`, 0) AS `ApplicationBlocked`, 
		cn.`ContentID`, cn.`Name` AS `ContentName`, IFNULL(cn.`Approval`, 0) AS `ContentApproval`, IFNULL(cn.`Blocked`, 0) AS `ContentBlocked`, cn.`TotalFileSize` AS `AmountOfFileSize`,
		IFNULL(st.`Country`, '') AS `Country`, IFNULL(st.`City`, '') AS `City`, IFNULL(st.`District`, '') AS `District`, IFNULL(st.`Quarter`, '') AS `Quarter`, IFNULL(st.`Avenue`, '') AS `Avenue`, IFNULL(st.`Lat`, '') AS `Lat`, IFNULL(st.`Long`, '') AS `Long`
		
	FROM `Customer` cu 
		INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
		INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
		INNER JOIN `Statistic` st ON st.`CustomerID`=cu.`CustomerID` AND st.`ApplicationID`=ap.`ApplicationID` AND st.`ContentID`=cn.`ContentID` AND st.`Type`='10' AND st.`Time` BETWEEN '{SD}' AND '{ED}' AND (st.`Country`={COUNTRY} OR {COUNTRY} IS NULL) AND (st.`City`={CITY} OR {CITY} IS NULL) AND (st.`District`={DISTRICT} OR {DISTRICT} IS NULL)
	WHERE 
		cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
		ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
		cu.`StatusID`=1
) t