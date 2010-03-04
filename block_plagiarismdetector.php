<?PHP //$Id: $

class block_plagiarismdetector extends block_list {
    function init() {
        $this->title = get_string('modulename','plagiarismdetector');
        $this->version = 2010030411;
     }
    function get_content () {
        global $USER, $CFG, $COURSE;


        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $context = get_context_instance(CONTEXT_BLOCK, $this->instance->id);
        
        $viewassignments = has_capability('mod/plagiarismdetector:view', $context);
        $viewself = has_capability('mod/plagiarismdetector:view', $context);

        if (!$viewassignments && !$viewself)    //Should not see the block
            return null;
        if ($viewassignments) {
            $assignments = get_all_instances_in_course("assignment", $COURSE);
            //var_dump($assignments);
            $this->content = new stdClass();
            $this->content->items = array();
            $this->content->icons = array();
            $this->content->footer = '';
            if (count($assignments)) {
                foreach ($assignments as $assignment) {
                    $this->content->icons[] = '<img src="'.$CFG->modpixpath.'/assignment/icon.gif"></img>';
                    $this->content->items[] = '<a href="'.$CFG->wwwroot.'/mod/plagiarismdetector/index.php?a='.$assignment->id.'">'.format_string($assignment->name,true).'</a>';
                }
                //var_dump($assignments);
                /*$this->content->footer = 'footer';*/
                //$this->content->footer = '<a href="'.$CFG->wwwroot.'/mod/plagiarismdetector/index.php">'.get_string('blockmanual','block_plagiarism_detector').'</a>';
            }
        }
        else if ($viewself) {
            //$this->content->text = 'Tu práctica no ha sido revisada';
        }

        return $this->content;
    }
}

?>
