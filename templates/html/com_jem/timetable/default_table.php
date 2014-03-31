<?php
/**
 * @version 1.9.5
 * @package JEM
 * @copyright (C) Steven Trooster / Ghost Art digital media
 * @copyright (C) 2013-2013 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;
?>
<script type="text/javascript">
	function tableOrdering(order, dir, view)
	{
		var form = document.getElementById("adminForm");

		form.filter_order.value 	= order;
		form.filter_order_Dir.value	= dir;
		form.submit(view);
	}
</script>
		
<div id="schedule" class="hours10">
<div class="shows">
	<a class="showEarly" href="#"><span>previous</span></a>
	<a class="showLate" href="#"><span>next</span></a>
	<ul>
		<li class="timeLegend timeLegendTop">
			<div class="slidethis" style="left:-960px;">
				<div class="timeline">
					<span class="h16 m0 d2">16:00</span>
					<span class="h16 m30 d2">16:30</span>
					<span class="h17 m0 d2">17:00</span>
					<span class="h17 m30 d2">17:30</span>
					<span class="h18 m0 d2">18:00</span>
					<span class="h18 m30 d2">18:30</span>
					<span class="h19 m0 d2">19:00</span>
					<span class="h19 m30 d2">19:30</span>
					<span class="h20 m0 d2">20:00</span>
					<span class="h20 m30 d2">20:30</span>
					<span class="h21 m0 d2">21:00</span>
					<span class="h21 m30 d2">21:30</span>
					<span class="h22 m0 d2">22:00</span>
					<span class="h22 m30 d2">22:30</span>
					<span class="h23 m0 d2">23:00</span>
					<span class="h23 m30 d2">23:30</span>
					<span class="h0 m0 d2">0:00</span>
					<span class="h0 m30 d2">0:30</span>
					<span class="h1 m0 d2">1:00</span>
					<span class="h1 m30 d2">1:30</span>
					<span class="h2 m0 d2">2:00</span>
				</div>
			<div class="grid"></div>
		</div>
		<h3></h3>
	</li>
<?php $this->rows = $this->getRows(); ?>
<?php foreach ($this->rows as $row) : ?>
		<li id="venue-01" class="venue row<?php echo ($row->odd +1) . $this->params->get('pageclass_sfx'); ?>" itemscope="itemscope" itemtype="http://schema.org/Event">
			<h3>
			<?php if ($this->jemsettings->showlocate == 1) : ?>
				<?php echo $row->locid ? $this->escape($row->venue) : '-'; ?>
			<?php endif; ?>
			</h3>
			<div class="slideThis">
				<div class="grid"></div>
				<ul class="showList">
				<!-- class van de show wordt bepaald door uur, minuten en duur -->
				<?php
					$datetime1 = new DateTime($row->dates.' '.$row->times);
					$datetime2 = new DateTime($row->dates.' '.$row->endtimes);
					$interval = $datetime1->diff($datetime2);
					$d = round(($interval->format('%H') * 60 + $interval->format('%i'))/15);
				?>

					<li id="event-01" class="h<?php echo $row->h; ?> m<?php echo $row->m; ?> d<?php echo $d; ?>">
						<?php if (($this->jemsettings->showtitle == 1) && ($this->jemsettings->showdetails == 1)) : ?>
							<a href="<?php echo JRoute::_(JEMHelperRoute::getEventRoute($row->slug)); ?>" itemprop="url">
							<span itemprop="name"><?php echo $this->escape($row->title); ?></span>
							</a>
						<?php endif; ?>					
					</li>
				</ul>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
</div>		
		


<table class="eventtable" style="width:<?php echo $this->jemsettings->tablewidth; ?>;" summary="jem">
	<colgroup>
		<?php if ($this->jemsettings->showlocate == 1) :	?>
			<col width="<?php echo $this->jemsettings->locationwidth; ?>" class="jem_col_venue" />
		<?php endif; ?>
			<col width="<?php echo $this->jemsettings->datewidth; ?>" class="jem_col_date" />
		<?php if ($this->jemsettings->showtitle == 1) : ?>
			<col width="<?php echo $this->jemsettings->titlewidth; ?>" class="jem_col_title" />
		<?php endif; ?>
		<?php if ($this->jemsettings->showcity == 1) :	?>
			<col width="<?php echo $this->jemsettings->citywidth; ?>" class="jem_col_city" />
		<?php endif; ?>
		<?php if ($this->jemsettings->showstate == 1) :	?>
			<col width="<?php echo $this->jemsettings->statewidth; ?>" class="jem_col_state" />
		<?php endif; ?>
		<?php if ($this->jemsettings->showcat == 1) :	?>
			<col width="<?php echo $this->jemsettings->catfrowidth; ?>" class="jem_col_category" />
		<?php endif; ?>
	</colgroup>

	<thead>
		<tr>
			<?php if ($this->jemsettings->showlocate == 1) : ?>
			<th id="jem_location" class="sectiontableheader" align="left"><?php echo JHtml::_('grid.sort', 'COM_JEM_TABLE_LOCATION', 'l.venue', $this->lists['order_Dir'], $this->lists['order']); ?></th>
			<?php endif; ?>
			<th id="jem_date" class="sectiontableheader" align="left"><?php echo JHtml::_('grid.sort', 'COM_JEM_TABLE_DATE', 'a.dates', $this->lists['order_Dir'], $this->lists['order']); ?></th>
			<?php if ($this->jemsettings->showtitle == 1) : ?>
			<th id="jem_title" class="sectiontableheader" align="left"><?php echo JHtml::_('grid.sort', 'COM_JEM_TABLE_TITLE', 'a.title', $this->lists['order_Dir'], $this->lists['order']); ?></th>
			<?php endif; ?>
			<?php if ($this->jemsettings->showcity == 1) : ?>
			<th id="jem_city" class="sectiontableheader" align="left"><?php echo JHtml::_('grid.sort', 'COM_JEM_TABLE_CITY', 'l.city', $this->lists['order_Dir'], $this->lists['order']); ?></th>
			<?php endif; ?>
			<?php if ($this->jemsettings->showstate == 1) : ?>
			<th id="jem_state" class="sectiontableheader" align="left"><?php echo JHtml::_('grid.sort', 'COM_JEM_TABLE_STATE', 'l.state', $this->lists['order_Dir'], $this->lists['order']); ?></th>
			<?php endif; ?>
			<?php if ($this->jemsettings->showcat == 1) : ?>
			<th id="jem_category" class="sectiontableheader" align="left"><?php echo JHtml::_('grid.sort', 'COM_JEM_TABLE_CATEGORY', 'c.catname', $this->lists['order_Dir'], $this->lists['order']); ?></th>
			<?php endif; ?>
		</tr>
	</thead>

	<tbody>
	<?php if ($this->noevents == 1) : ?>
		<tr align="center"><td colspan="20"><?php echo JText::_('COM_JEM_NO_EVENTS'); ?></td></tr>
	<?php else : ?>
		<?php $this->rows = $this->getRows(); ?>
		<?php foreach ($this->rows as $row) : ?>
			<tr class="sectiontableentry<?php echo ($row->odd +1) . $this->params->get('pageclass_sfx'); ?>"
				itemscope="itemscope" itemtype="http://schema.org/Event">

				<?php if ($this->jemsettings->showlocate == 1) : ?>
					<td headers="jem_location" align="left" valign="top">
						<?php if ($this->jemsettings->showlinkvenue == 1) : ?>
							<?php echo $row->locid != 0 ? "<a href='".JRoute::_(JEMHelperRoute::getVenueRoute($row->venueslug))."'>".$this->escape($row->venue)."</a>" : '-'; ?>
						<?php else : ?>
							<?php echo $row->locid ? $this->escape($row->venue) : '-'; ?>
						<?php endif; ?>
					</td>
				<?php endif; ?>

				<td headers="jem_date" align="left">
					<?php
						echo JEMOutput::formatShortDateTime($row->dates, $row->times,
							$row->enddates, $row->endtimes);
						echo JEMOutput::formatSchemaOrgDateTime($row->dates, $row->times,
							$row->enddates, $row->endtimes);
					?>
				</td>

				<?php if (($this->jemsettings->showtitle == 1) && ($this->jemsettings->showdetails == 1)) : ?>
					<td headers="jem_title" align="left" valign="top">
						<a href="<?php echo JRoute::_(JEMHelperRoute::getEventRoute($row->slug)); ?>" itemprop="url">
							<span itemprop="name"><?php echo $this->escape($row->title); ?></span>
						</a>
					</td>
				<?php endif; ?>

				<?php if (($this->jemsettings->showtitle == 1) && ($this->jemsettings->showdetails == 0)) : ?>
					<td headers="jem_title" align="left" valign="top" itemprop="name"><?php echo $this->escape($row->title); ?></td>
				<?php endif; ?>


				<?php if ($this->jemsettings->showcity == 1) : ?>
					<td headers="jem_city" align="left" valign="top"><?php echo $row->city ? $this->escape($row->city) : '-'; ?></td>
				<?php endif; ?>

				<?php if ($this->jemsettings->showstate == 1) : ?>
					<td headers="jem_state" align="left" valign="top"><?php echo $row->state ? $this->escape($row->state) : '-'; ?></td>
				<?php endif; ?>

				<?php if ($this->jemsettings->showcat == 1) : ?>
					<td headers="jem_category" align="left" valign="top">
					<?php echo implode(", ",
							JEMOutput::getCategoryList($row->categories, $this->jemsettings->catlinklist)); ?>
					</td>
				<?php endif; ?>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
</table>