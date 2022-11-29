<?php

class PagesController extends Controller
{
    public function view($id)
    {
        $this->loadModel("Post");
        $d["page"] = $this->Post->findFirst([
            "conditions" => ["id" => $id, "type" => "page", "online" => 1]
        ]);
        // $d["pages"] = $this->Post->findAll([
        //     "conditions" => ["type" => "page", "online" => 1]
        // ]);
        !empty($d["page"]) ? $this->set($d) : $this->e404("Page introuvable!");
    }

    /**
     * getMenu  | Permet de recuperer les pages pour le menu
     * @return void
     */
    public function getMenu()
    {
        $this->loadModel("Post");
        return $this->Post->findAll([
            "conditions" => ["type" => "page", "online" => 1]
        ]);
    }
}
