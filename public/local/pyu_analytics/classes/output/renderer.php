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

class renderer extends \plugin_renderer_base {

    public function render_dashboard(dashboard $dashboard) {
        $data = $dashboard->export_for_template($this);
        $data['engagement_data'] = json_encode($data['engagement_data'] ?? []);
        $data['heatmap_data'] = json_encode($data['heatmap_data'] ?? []);
        return $this->render_from_template('local_pyu_analytics/dashboard', $data);
    }
}
