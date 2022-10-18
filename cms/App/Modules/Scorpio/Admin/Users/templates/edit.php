<?php $route = \Crm\Route\Route::getInstance(); ?>
<form class="row g-5" action="<?= $route->name('scorpio.users.update', ['id' => $id]) ?>" method="post">
  <div class="col-auto">
    <label for="name" class="col-sm-3 col-form-label">Имя</label>
    <input type="text" class="form-control" name="name" value="<?= $user['name'] ?>" id="name">
  </div>

  <div class="col-auto">
    <label for="email" class="col-sm-3 col-form-label">Email</label>
    <input type="email" class="form-control" name="email" value="<?= $user['email'] ?>" id="email">
  </div>
  <div class="row mt-3">
    <div class="col-sm px-4">
      <button type="submit" name="save" class="btn btn-outline-danger mb-3">Сохранить</button>
      <button type="submit" name="applay" class="btn btn-outline-warning mb-3">Применить</button>
    </div>
  </div>
</form>
