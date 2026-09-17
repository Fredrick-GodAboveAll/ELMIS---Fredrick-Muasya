# DB Backup Checklist

## Before backup
- [ ] Verify database is reachable
- [ ] Verify backup storage path is writable
- [ ] Confirm permissions are correct
- [ ] Confirm backup job is scheduled

## During backup
- [ ] Check logging output
- [ ] Confirm file is created successfully
- [ ] Confirm file size is reasonable

## After backup
- [ ] Validate backup readability
- [ ] Confirm backup retention is in place
- [ ] Store backup in secure location
- [ ] Record time and version of the backup

## Restore test
- [ ] Perform restore test periodically
- [ ] Validate app-critical data after restore
- [ ] Confirm recovery time objective is acceptable
