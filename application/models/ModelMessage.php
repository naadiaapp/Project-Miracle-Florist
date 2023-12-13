<?php

class ModelMessage extends CI_Model
{

    public function get()
    {
        $this->db->from("messages");
        return $this->db->get();
    }
    public function update($data, $id)
    {
        $this->db->where(["id" => $id]);
        $this->db->update("messages", $data);
    }
    public function delete($id) 
    {
        $this->db->where('id', $id);
        $this->db->delete('messages');
    }

}

?>