<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.')); ?>
<table class="calendar">
    <thead>
        <tr class="navigation">
            <th colspan="7" class="current-month"><?php echo $calendar->month() ?> <?php echo $calendar->year ?></th>
        </tr>
        <tr class="weekdays">
            <?php foreach ($calendar->days() as $day) { ?>
                <th><?php echo $day ?></th>
	    <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($calendar->weeks() as $week) { ?>
            <tr>
                <?php foreach ($week as $day) { ?>
                    <?php
                    list($number, $current, $data) = $day;

                    $classes = array();
                    $output  = '';

                    if (is_array($data)) {
                        $classes = $data['classes'];
                        $title   = $data['title'];
                        $output  = empty($data['output']) ? '' : '<ul class="output">'.implode('', $data['output']).'</ul>';
                    }
                    ?>
                    <td class="day <?php echo implode(' ', $classes) ?>">
                        <span class="date" title="<?php echo implode(' / ', $title) ?>"><?php echo $number ?></span>
                        <div class="day-content">
                            <?php echo $output ?>
                        </div>
                    </td>
		<?php } ?>
            </tr>
	<?php } ?>
    </tbody>
</table>
<p><a href="#caliCal" data-toggle="modal" class="label label-info">iCal</a></p>
	<!--<pre><?php print_r($modals); ?></pre>-->
<?php
foreach ($modals as $id => $object) { ?>
	<div class="modal fade" id="cal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $object['type']; ?>" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><?php echo $object['type']; ?></h4>
				</div>
				<div class="modal-body">
					<?php echo parse($object['description']); ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
<?php }
