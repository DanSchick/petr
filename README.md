$dbReader="piDxRFLQAYi18VT6";
$dbWriter="yCWDDAhRAaEc9OgZ";
$dbAdmin="OJJXm3iGQFFXooUv";


Query to insert multiple rows for tblSeen

INSERT INTO tblSeen ('pmkUserId', 'fnkProfileId')
SELECT 'dschick', pmkId FROM tblOwners
