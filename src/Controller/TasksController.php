<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 *
 * @method \App\Model\Entity\Task[] paginate($object = null, array $settings = [])
 */
class TasksController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            "contain" => ["Users"]
        ];
        $tasks = $this->paginate($this->Tasks);

        $this->set(compact("tasks"));
        $this->set("_serialize", ["tasks"]);
    }

    /**
     * View method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $task = $this->Tasks->get($id, [
            "contain" => ["Users"]
        ]);

        $this->set("task", $task);
        $this->set("_serialize", ["task"]);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $task = $this->Tasks->newEntity();
        if ($this->request->is("post")) {
        	$data = $this->request->getData();
        	$data["user_id"] = $this->usuario["id"];
        	debug($data);

            $task = $this->Tasks->patchEntity($task, $data, [
            	"associated" => "Users"
			]);
			debug($task);
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__("The task has been saved."));

                return $this->redirect(["action" => "index"]);
            }
            $this->Flash->error(__("The task could not be saved. Please, try again."));
        }
        $users = $this->Tasks->Users->find("list", ["limit" => 200]);
        $this->set(compact("task", "users"));
        $this->set("_serialize", ["task"]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $task = $this->Tasks->get($id, [
            "contain" => []
        ]);
        if ($this->request->is(["patch", "post", "put"])) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__("The task has been saved."));

                return $this->redirect(["action" => "index"]);
            }
            $this->Flash->error(__("The task could not be saved. Please, try again."));
        }
        $users = $this->Tasks->Users->find("list", ["limit" => 200]);
        $this->set(compact("task", "users"));
        $this->set("_serialize", ["task"]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(["post", "delete"]);
        $task = $this->Tasks->get($id);
        if ($this->Tasks->delete($task)) {
            $this->Flash->success(__("The task has been deleted."));
        } else {
            $this->Flash->error(__("The task could not be deleted. Please, try again."));
        }

        return $this->redirect(["action" => "index"]);
    }
}
