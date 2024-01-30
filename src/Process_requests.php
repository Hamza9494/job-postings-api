<?php 
class Process_requests {
    
    public function process_all_request($id) {
        if($id) {
            $this->proecess_resource_request($id);
        } else {
            $this->process_collection_request();
        }
    }
    

    private function process_collection_request() {
        echo "i process collection requests";
    }

    private function proecess_resource_request($id) {
        echo "i process resource request";
    }
}

?>