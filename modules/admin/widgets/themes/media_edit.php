<?php
/*
  this needs to loop through the feed list all of the pages ids, titles,
  the user who published it and the date with a form hidden under it
  with all of the editable fields
*/
foreach($media_items->get_feed_objects() as $page):
    $fields = array(
        'id' => $page->get_id(),
        'title' => $page->get_title()
    );
    foreach($form_fields as $key => $values){
        if(isset($fields[@$values['name']])){
            $form_fields[$key]['default'] = $fields[$values['name']];
        }
    }
    $form->set_fields($form_fields);
?>
<div class='editpage'>
    <div class='editpage-id'><?php echo $page->get_id(); ?></div>
    <div class='editpage-title'><?php echo $page->get_title(); ?></div>
    <div class='editpage-author'><?php echo $page->get_author(); ?></div>
    <div class='editpage-date'><?php echo $page->get_published('d/m/Y'); ?></div>
    <div class='editpage-button'><a href='#'>edit</a></div>
    <div class='editpage-form hide'><?php echo $form->get_form(); ?></div>
</div>
<?php
endforeach;
?>