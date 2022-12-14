<?php

class PostsController extends Controller
{
    public function index()
    {
        $perPage = 1;
        $this->loadModel("Post");
        $conditions = ["type" => "post", "online" => 1];
        $d["posts"] = $this->Post->findAll([
            "conditions" => $conditions,
            "limit" => ($perPage * ($this->request->page - 1) . ", " . $perPage)
        ]);
        $d["total"] = $this->Post->findCount($conditions);
        $d["nbrePages"] = ceil($d["total"] / $perPage);
        $this->set($d);
    }

    public function view($id, $slug)
    {
        $this->loadModel("Post");
        $conditions = ["id" => $id, "type" => "post"];
        $d["post"] = $this->Post->findFirst([
            "fields"     => "id, title, slug, content",
            "conditions" => $conditions
        ]);

        // Si le post contient des valeurs, on les transmet a la vue, sinon on renvoie une 404
        !empty($d["post"]) ? $this->set($d) : $this->e404("Page introuvable!");

        // Si l'url fourni par l'utilisateur est different de l'url qui est en db
        if ($slug != $d["post"]->slug) {
            $this->redirect("posts/view/id:$id/slug:" . $d["post"]->slug, 301);
        }
    }

    public function admin_index()
    {
        $perPage = 10;
        $this->loadModel("Post");
        $conditions = ["type" => "post"];
        $d["posts"] = $this->Post->findAll([
            "fields" => "id, title, online",
            "conditions" => $conditions,
            "limit" => ($perPage * ($this->request->page - 1) . ", " . $perPage)
        ]);
        $d["total"] = $this->Post->findCount($conditions);
        $d["nbrePages"] = ceil($d["total"] / $perPage);
        $this->set($d);
    }

    public function admin_edit($id = NULL)
    {
        $this->loadModel("Post");
        if ($this->request->data) {
            $this->Post->save($this->request->data);
            $id = $this->Post->id;
        }
        $this->request->data = $this->Post->findFirst([
            "conditions" => ["id" => $id]
        ]);
    }

    public function admin_delete($id)
    {
        $this->loadModel("Post");
        $this->Post->delete($id);
        $this->Session->setFlash("Le contenu a bien ??t?? supprim??");
        $this->redirect("admin/posts/index");
    }
}
