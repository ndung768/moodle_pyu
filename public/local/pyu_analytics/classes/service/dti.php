<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace local_pyu_analytics\service;

defined('MOODLE_INTERNAL') || die();

/**
 * Digital Transformation Index service.
 *
 * @package    local_pyu_analytics
 * @copyright  2025 Phu Yen University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class dti {

    /**
     * Rebuild DTI scores per unit.
     */
    public function rebuild_dti(): void {
        global $DB;

        $tablename = 'local_pyu_analytics_dti';
        $coursetable = 'local_pyu_analytics_course';
        $unittable = 'local_pyu_analytics_unit';

        if (!$DB->get_manager()->table_exists($unittable)) {
            return;
        }

        $now = time();
        $periodstart = $now - (30 * DAYSECS);
        $units = $DB->get_records($unittable, ['unittype' => 'faculty']);
        foreach ($units as $unit) {
            $courses = $DB->get_records($coursetable, [
                'unitid' => $unit->id,
                'periodstart' => $periodstart,
                'periodend' => $now,
            ]);
            $eng = 0;
            $cnt = 0;
            $asm = 0;
            $n = count($courses);
            foreach ($courses as $c) {
                $eng += $c->engagementrate;
                $cnt += 1;
                $asm += min(100, ($c->assignmentcount + $c->quizcount) * 10);
            }
            $engsum = 0;
            $asmsum = 0;
            foreach ($courses as $c) {
                $engsum += $c->engagementrate;
                $asmsum += min(100, ($c->assignmentcount + $c->quizcount) * 15);
            }
            $engagementscore = $n > 0 ? round($engsum / $n, 2) : 0;
            $contentscore = $n > 0 ? 50 : 0;
            $assessmentscore = $n > 0 ? round($asmsum / $n, 2) : 0;
            $dtiscore = round(0.4 * $engagementscore + 0.3 * $contentscore + 0.3 * $assessmentscore, 2);

            $record = (object) [
                'unitid' => $unit->id,
                'periodstart' => $periodstart,
                'periodend' => $now,
                'engagementscore' => $engagementscore,
                'contentscore' => $contentscore,
                'assessmentscore' => $assessmentscore,
                'dtiscore' => $dtiscore,
                'timemodified' => $now,
            ];
            $existing = $DB->get_record($tablename, [
                'unitid' => $unit->id,
                'periodstart' => $periodstart,
                'periodend' => $now,
            ]);
            if ($existing) {
                $record->id = $existing->id;
                $DB->update_record($tablename, $record);
            } else {
                $record->timecreated = $now;
                $DB->insert_record($tablename, $record);
            }
        }
    }
}
