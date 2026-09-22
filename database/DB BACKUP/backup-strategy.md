# Database Backup Strategy

## Overview
This document is the working draft for the database backup strategy used by ELMIS.

## Objectives
- Protect critical application and employee data
- Reduce the risk of irreversible data loss
- Support disaster recovery and restoration procedures
- Provide a repeatable process for database operators and administrators

## Scope
This strategy covers:
- application database backup scheduling
- storage and retention
- verification and restore readiness
- operational responsibilities

## Backup approach
Use a dependable automated backup process for the primary MySQL/MariaDB database. The backup process should:
- capture a full or logical dump of the database
- run according to a defined schedule
- write backups to a secure storage location
- protect backups from accidental deletion or tampering

## Recommended schedule
- Daily full backup
- Incremental or point-in-time backups if the environment supports them
- Additional backups before major deployments or data changes

## Storage requirements
- Backups should be stored outside the application server filesystem when possible
- Use secure storage access controls
- Keep backups encrypted or otherwise protected from unauthorized access
- Maintain retention based on business and compliance needs

## Validation
- Check backup files after creation
- Confirm the backup is readable and complete
- Document a testing process for restore validation

## Restore readiness
A backup is only useful if it can be restored. Restore planning should include:
- required database credentials
- restore commands or scripts
- validation steps after restore
- downtime or maintenance planning

## Ownership
This backup strategy should be reviewed by the project owner, technical lead, and hosting/admin team before production use.

## Notes
This is a starting draft only and should be expanded once the production hosting model, database engine, and retention policy are confirmed.
