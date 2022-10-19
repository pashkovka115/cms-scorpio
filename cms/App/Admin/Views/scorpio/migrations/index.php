@extends(index, page)

<?php $route = \Crm\Route\Route::getInstance() ?>
<div class="row">
  <div class="col-auto">
    <form class="row g-3" action="<?= $route->name('scorpio.migrations.store') ?>" method="post">
      <div class="col-auto">
        <label for="staticEmail2" class="visually-hidden">Новая миграция:</label>
        <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Новая миграция:">
      </div>
      <div class="col-auto">
        <label for="inputtext" class="visually-hidden">Имя таблицы</label>
        <input type="text" name="name" class="form-control" id="inputtext" placeholder="Имя таблицы">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary mb-3">Создать</button>
      </div>
    </form>
  </div>
  <div class="col-auto">
    <form class="row g-3" action="<?= $route->name('scorpio.migrations.up.all') ?>" method="post">
      <div class="col-auto">
        <button type="submit" class="btn btn-success mb-3">Выполнить всё</button>
      </div>
    </form>
  </div>
  <div class="col-auto">
    <form class="row g-3" action="<?= $route->name('scorpio.migrations.down.all') ?>" method="post">
      <div class="col-auto">
        <button type="submit" class="btn btn-warning mb-3">Откатить всё</button>
      </div>
    </form>
  </div>
</div>




<table class="table table-striped color-white">
    <thead>
    <tr>
        <th scope="col">Имя</th>
        <th scope="col">#</th>
        <th scope="col">#</th>
        <th scope="col">#</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($files as $file) { ?>
        <?php if (!is_array($file)){ ?>
        <tr>
            <th scope="row" title="<?= $file ?>"><?= basename($file) ?></th>
            <td>
              <form action="<?= $route->name('scorpio.migrations.up') ?>" method="post">
                <input type="hidden" name="file_name" value="<?= $file ?>">
                <input type="submit" name="up" value="Выполнить" class="btn btn-success">
              </form>
            </td>
            <td>
              <form action="<?= $route->name('scorpio.migrations.down') ?>" method="post">
                <input type="hidden" name="file_name" value="<?= $file ?>">
                <input type="submit" name="down" value="Откатить" class="btn btn-warning">
              </form>
            </td>
            <td>
              <form action="<?= $route->name('scorpio.migrations.destroy') ?>" method="post">
                <input type="hidden" name="file_name" value="<?= $file ?>">
                <input type="submit" name="destroy" value="Удалить" class="btn btn-danger">
              </form>
            </td>

        </tr>
            <?php } ?>
    <?php } ?>
    </tbody>
</table>