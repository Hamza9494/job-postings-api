<?php
class Process_requests
{

    public function __construct(private Jobs_gateaway $gateaway, private $user_id, private $type, private $client)
    {
    }

    public function process_all_request($method, $id)
    {
        if ($id) {
            $this->proecess_resource_request($method, $id);
        } else {
            $this->process_collection_request($method, $this->user_id, $this->type, $this->client);
        }
    }


    private function process_collection_request($method, $user_id, $type, $client)
    {
        switch ($method) {

            case "POST":
                $job = json_decode(file_get_contents("php://input"), true);
                $id = $this->gateaway->create($job, $user_id);
                if ($id) {
                    echo json_encode(["job_added" => true, "id" => $id]);
                    http_response_code(201);
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "could not add job"]);
                }
                break;

            case "GET":
                if ($type === "client") {
                    $jobs = $this->gateaway->get_all($user_id, $client);
                    echo json_encode($jobs);
                } else {
                    $jobs = $this->gateaway->get_all($user_id, $client, $type);
                    echo json_encode($jobs);
                }
                break;

            default:
                http_response_code(405);
                header("Allow methods: POST , GET");
        };
    }

    private function proecess_resource_request($method, $id)
    {
        switch ($method) {

            case "GET":
                $job =  $this->gateaway->get($id);
                echo json_encode($job);
                break;

            case "DELETE";
                $row = $this->gateaway->delete($id);
                echo json_encode(["deleted" => true, "affected_rows" => $row]);
                break;

            case "PUT":
                $old = $this->gateaway->get($id);
                $new = json_decode(file_get_contents("php://input"), true);
                $row =  $this->gateaway->update($old, $new, $id);
                echo json_encode(["update success" => true, "row_affected" => $row]);
        }
    }
}
