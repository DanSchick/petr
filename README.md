


Query to insert multiple rows for tblSeen

INSERT INTO tblSeen ('pmkUserId', 'fnkProfileId')
SELECT 'dschick', pmkId FROM tblOwners
