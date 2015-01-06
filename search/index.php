<?php
$pageTitle = __('Search Omeka ') . __('(%s total)', $total_results);
echo head(array('title' => $pageTitle, 'bodyclass' => 'search'));
$searchRecordTypes = get_search_record_types();
?>
<?php echo search_filters(); ?>

<?php if ($total_results): ?>

<div id="search-filters" style="display:inline; float:none;">
<ul><li><?php echo __('Total results: ');?> <?php echo $total_results; ?></li></ul>
</div>

<?php echo pagination_links(); ?>

<?php foreach (loop('search_texts') as $searchText): ?>
<?php endforeach; ?>

<table id="search-results">
    <thead>
        <tr>
            <th><?php echo __('Item Type');?></th>
            <th><?php echo __('Identifier');?></th>
            <th><?php echo __('Subgenre');?></th>
            <th><?php echo __('Title');?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach (loop('search_texts') as $searchText): ?>
        <?php $record = get_record_by_id($searchText['record_type'], $searchText['record_id']); ?>
        
        <?php if ($searchRecordTypes[$searchText['record_type']] == "Item"):?>
            <?php $itemtypename = metadata($record, 'Item Type Name') ? metadata($record, 'Item Type Name') : "";?>
        <?php elseif ($searchRecordTypes[$searchText['record_type']] == __("File")):?>
            <?php $itemtypename = "File"; ?>
        <?php endif; ?>
        <tr class="<?php echo $itemtypename; ?>">
            <td>
                <?php echo __($itemtypename); ?>
            </td>
            
            <td><a href="<?php echo record_url($record, 'show'); ?>"><?php echo metadata($record, array('Dublin Core', 'Identifier')); ?></a></td>
            
            <td><?php if ($searchRecordTypes[$searchText['record_type']] == "Item"): ?>
            <?php echo metadata($record, array('Item Type Metadata', 'Subgenre')) ? metadata($record, array('Item Type Metadata', 'Subgenre')) : ""; ?>
            <?php endif; ?></td>

            <td><a href="<?php echo record_url($record, 'show'); ?>"><?php echo $searchText['title'] ? $searchText['title'] : __('Untitled'); ?></a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php echo pagination_links(); ?>
<?php else: ?>
<div id="no-results">
    <p><?php echo __('Your query returned no results.');?></p>
</div>
<?php endif; ?>
<?php echo foot(); ?>