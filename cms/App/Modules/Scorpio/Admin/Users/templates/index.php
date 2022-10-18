<?php $route = \Crm\Route\Route::getInstance() ?>
<table class="table table-striped color-white">
  <thead>
  <tr>
    <th scope="col">ID</th>
    <th scope="col">Имя</th>
    <th scope="col">Email</th>
    <th scope="col">#</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($users as $user) { ?>
    <tr>
      <th scope="row"><?= $user['id'] ?></th>
      <td><a href="<?= $route->name('scorpio.users.edit', ['id' => $user['id']]) ?>"><?= $user['name'] ?></a></td>
      <td><?= $user['email'] ?></td>
      <td><a href="<?= $route->name('scorpio.users.destroy', ['id' => $user['id']]) ?>">Удалить</a></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
