<?php // var_dump($users); ?>

<div class="row">

            <?php
            global $app;
            $app->flash();
            ?>

            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Users
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <div class="panel-body">

                    <div>
                        <a href="<?php echo imv_url('user_create') ?>" class="btn btn-success">Create New User</a>
                    </div>

                    <div class="adv-table">
                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Country</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach( $users as $user ): ?>
                        <tr class="gradeA">
                            <td><?php echo $user['user_id'] ?></td>
                            <td>
                                <a href="index.php?action=user_view&amp;id=<?php echo $user['user_id']?>&amp;ret=users">
                                    <?php echo $user['first_name']?> <?php echo $user['last_name'] ?>
                                </a>
                            </td>
                            <td><?php echo $user['email'] ?></td>
                            <td><?php echo $user['country'] ?></td>
                            <td>
                                <a title="View" href="index.php?action=user_view&amp;id=<?php echo $user['user_id']?>&amp;ret=users" class="btn btn-xs btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <a title="Edit" href="index.php?action=user_edit&amp;id=<?php echo $user['user_id']?>&amp;ret=users" class="btn btn-xs btn-success">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <a title="Delete" href="index.php?action=user_delete&amp;id=<?php echo $user['user_id']?>&amp;ret=users" class="btn btn-xs btn-danger" onclick="return confirm('Do you want to delete this user?');">
                                    <i class="fa fa-times-circle"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ;?>

                    <!--  -->
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Country</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    </table>
                    </div>
                    </div>
                </section>
            </div>
        </div>
