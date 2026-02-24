# PYU Analytics Dashboard

Smart Analytics Dashboard for Phu Yen University Executive Board (Moodle 5.1.1+).

## Installation

1. Copy `pyu_analytics` to `moodle/local/`
2. Visit **Site administration → Notifications**
3. Click **Upgrade Moodle database now**
4. Purge caches

## Access

- **Reports → Analytics Dashboard**
- Requires capability: `local/pyu_analytics:view` (managers, editing teachers)

## Scheduled Task

- **Rebuild PYU Analytics metrics** runs hourly
- Aggregates: engagement, course metrics, risk scores, DTI

## Configuration

1. **Units**: Add faculties/departments to `local_pyu_analytics_unit`
2. **Course mapping**: Map courses to units in `local_pyu_analytics_course_unit`
3. Run the scheduled task or trigger rebuild manually

## Tables

- `local_pyu_analytics_unit` - Organisational units
- `local_pyu_analytics_course_unit` - Course→unit mapping
- `local_pyu_analytics_daily` - Daily activity cache
- `local_pyu_analytics_course` - Course metrics
- `local_pyu_analytics_risk` - Student risk scores
- `local_pyu_analytics_dti` - Digital Transformation Index
