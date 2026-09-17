# DB Backup Strategy

This folder contains the starting point for the database backup strategy for ELMIS.

## Purpose
- Define how application databases are backed up
- Describe when backups run
- Record retention expectations
- Document restore steps and responsibilities
- Provide a safe starting point for production operations

## Recommended baseline
- Take daily automated backups of the production database
- Keep a recent backup retention window (for example: 7 to 30 days depending on operational needs)
- Store backups in a secure, off-server location
- Validate backup integrity regularly
- Test restoration at least periodically

## Planned files
- `backup-strategy.md` — detailed backup plan
- `restore-procedure.md` — restore instructions
- `backup-checklist.md` — operational checklist
