<script type="text/javascript" src="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jquery.min.js"></script>
<script type="text/javascript" src="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jquery.simplemodal.min.js"></script>
    
<script type="text/javascript" src="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jquery-ui/jquery.ui.datepicker-ru.js"></script>
<script type="text/javascript" src="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jquery-ui/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jquery-ui/ui-lightness/jquery-ui.css" />

<script type="text/javascript" src="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jwysiwyg/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jwysiwyg/controls/wysiwyg.image.js"></script>
<script type="text/javascript" src="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jwysiwyg/controls/wysiwyg.link.js"></script>
<script type="text/javascript" src="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jwysiwyg/controls/wysiwyg.table.js"></script>
<script type="text/javascript" src="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jwysiwyg/controls/wysiwyg.colorpicker.js"></script>
<link rel="stylesheet" type="text/css" href="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jwysiwyg/jquery.wysiwyg.css" />
<link rel="stylesheet" type="text/css" href="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jwysiwyg/jquery.wysiwyg.modal.css" />
  
<script type="text/javascript">
  $(function() {
    $( "#event_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $(".delete").click(function(){
      if (confirm("Вы действительно хотите удалтить эту запись?")) {
          $(this).parent("form").submit();
      }
    });
    $(".event-description").wysiwyg({
      resizeOptions: true,
      initialContent: "",
      constrols: {
        insertTable: {visible: false},
        bold: {visible: false}
      }
    });
  });
</script>

<link rel="stylesheet" type="text/css" href="/wp-content/plugins/<?php echo $plugin_dir ?>/app/web/css/styles.css"" />

<div>
  <div>
    <form name="add_event" action="" method="post">
    
    <label for="event_date">Date</label>
    <div>
       <input type="text" name="event[date]"  id="event_date"  value="<?php echo $event['date'] ?>" />
    </div>
    
     <label for="event_title">Name</label>
    <div>
       <input type="text" name="event[title]"  id="event_title" value="<?php echo $event['title'] ?>" />
    </div>
    
        <label for="event_description">Description</label>
    <div>
      <textarea id="event_description" name="event[description]" class="event-description"><?php echo $event['description'] ?></textarea>
    </div>
    
    <input type="hidden" name="action" value="<?php echo $action ?>" />
    <input type="hidden" name="id" value="<?php echo $event['id'] ?>" />
    
    <input type="submit" class="button bold" value="Save" />
    </form>
  </div>

    <h2>Manage Events</h2>
  <?php if (! $events): ?>
    No events yet
  <?php else: ?>
  <table class="widefat page fixed">
    <thead>
      <tr>
      <th>id</th>
      <th>Date</th>
      <th>Title</th>
      <th>Description</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($events as $key => $row): ?>
    <tr>
      <td><?php echo $row['id'] ?></td>
      <td><?php echo $row['date'] ?></td>
      <td><?php echo $row['title'] ?></td>
      <td><?php echo $row['description'] ?></td>
      <td>
            <a href="/wp-admin/admin.php?page=calendar1&id=<?php echo $row['id'] ?>" class="edit">Edit</a>
          </td>
      <td>
            <form name="remove_event" action="" method="post">
        <span class="delete">Delete</span>
              <input type="hidden" name="event[id]" value="<?php echo $row['id'] ?>" />
              <input type="hidden" name="action" value="delete" />
            </form>
      </td>
    </tr>
    <?php endforeach ?>
    </tbody>
  </table>
  <?php endif ?>
  
</div>