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

namespace local_pyu_analytics\output;

defined('MOODLE_INTERNAL') || die();

use renderable;
use templatable;

/**
 * Dashboard renderable.
 *
 * @package    local_pyu_analytics
 * @copyright  2025 Phu Yen University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class dashboard implements renderable, templatable {

    /** @var array */
    protected $kpis;
    /** @var array */
    protected $engagementdata;
    /** @var array */
    protected $risksummary;
    /** @var array */
    protected $facultyrows;
    /** @var array */
    protected $heatmapdata;

    public function __construct(array $kpis, array $engagementdata, array $risksummary, array $facultyrows, array $heatmapdata) {
        $this->kpis = $kpis;
        $this->engagementdata = $engagementdata;
        $this->risksummary = $risksummary;
        $this->facultyrows = $facultyrows;
        $this->heatmapdata = $heatmapdata;
    }

    public function export_for_template(\renderer_base $output): array {
        return [
            'kpis' => $this->kpis,
            'engagement_data' => $this->engagementdata,
            'risk_summary' => $output->render_from_template('local_pyu_analytics/risk_summary', [
                'items' => $this->risksummary,
            ]),
            'faculty_table' => $output->render_from_template('local_pyu_analytics/faculty_table', [
                'rows' => $this->facultyrows,
            ]),
            'heatmap_data' => $this->heatmapdata,
        ];
    }
}
