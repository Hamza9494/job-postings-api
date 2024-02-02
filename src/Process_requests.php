<?php
class Process_requests
{
    public function __construct(Jobs_gateaway $gateaway, private $author_id)
    {
    }

    public function process_all_request($method, $id)
    {
        if ($id) {
            $this->proecess_resource_request($id);
        } else {
            $this->process_collection_request($method, $this->author_id);
        }
    }


    private function process_collection_request($method, $user_id)
    {
        switch ($method) {
            case "post":
                $job = json_decode(file_get_contents("php://input"), true);
                var_dump($job);
                break;
        };
    }

    private function proecess_resource_request($id)
    {
        echo "i process resource request";
    }
}
