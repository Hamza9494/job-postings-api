<?php
class Process_requests
{

    public function __construct(private Jobs_gateaway $gateaway, private $user_id)
    {
    }

    public function process_all_request($method, $id)
    {
        if ($id) {
            $this->proecess_resource_request($id);
        } else {
            $this->process_collection_request($method, $this->user_id);
        }
    }


    private function process_collection_request($method, $user_id)
    {
        switch ($method) {
            case "POST":
                $job = json_decode(file_get_contents("php://input"), true);
                $id = $this->gateaway->create($job, $user_id);
                echo json_encode(["job_added" => true, "id" => $id]);
                break;
            case "GET":
                $jobs = $this->gateaway->get_all($user_id);
                echo json_encode($jobs);
        };
    }

    private function proecess_resource_request($id)
    {
        echo "i process resource request";
    }
}
