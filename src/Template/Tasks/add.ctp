<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __("Actions") ?></li>
        <li><?= $this->Html->link(__("List Tasks"), ["action" => "index"]) ?></li>
        <li><?= $this->Html->link(__("List Users"), ["controller" => "Users", "action" => "index"]) ?></li>
        <li><?= $this->Html->link(__("New User"), ["controller" => "Users", "action" => "add"]) ?></li>
    </ul>
</nav>
<div class="tasks form large-9 medium-8 columns content">
    <?= $this->Form->create($task) ?>
    <fieldset>
        <legend><?= __("Add Task") ?></legend>
        <?php
            echo $this->Form->control("titulo");

            echo $this->Form->control("descricao");

            echo
				$this
					->Form
					->control(
						"prioridade",
						[
							"label" => "Prioridade (1 - 5)"
						]
					);
        ?>
    </fieldset>
    <?= $this->Form->button(__("Submit")) ?>
    <?= $this->Form->end() ?>
</div>
