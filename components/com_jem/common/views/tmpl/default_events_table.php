<?php
/**
 * @version 1.9.5
 * @package JEM
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

<?php if ($this->settings->get('global_show_filter',1) || $this->settings->get('global_display',1)) : ?>
	<div id="jem_filter" class="floattext">
		<?php if ($this->settings->get('global_show_filter',1)) : ?>
			<div class="jem_fleft">
				<?php
					echo '<label for="filter">'.JText::_('COM_JEM_FILTER').'</label>&nbsp;';
					echo $this->lists['filter'].'&nbsp;';
				?>
				<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->lists['search'];?>" class="inputbox" onchange="document.adminForm.submit();" />
				<button class="buttonfilter" type="submit"><?php echo JText::_('COM_JEM_GO'); ?></button>
				<button class="buttonfilter" type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
			</div>
		<?php endif; ?>
		<?php if ($this->settings->get('global_display',1)) : ?>
			<div class="jem_fright">
				<?php
					echo '<label for="limit">'.JText::_('COM_JEM_DISPLAY_NUM').'</label>&nbsp;';
					echo $this->pagination->getLimitBox();
				?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>

<table class="eventtable" style="width:<?php echo $this->jemsettings->tablewidth; ?>;" summary="jem">
	<colgroup>
		<?php if ($this->jemsettings->showeventimage == 1) : ?>
			<col width="<?php echo $this->jemsettings->tableeventimagewidth; ?>" class="jem_col_event_image" />
		<?php endif; ?>
			<col width="<?php echo $this->jemsettings->datewidth; ?>" class="jem_col_date" />
		<?php if ($this->jemsettings->showtitle == 1) : ?>
			<col width="<?php echo $this->jemsettings->titlewidth; ?>" class="jem_col_title" />
		<?php endif; ?>
		<?php if ($this->jemsettings->showlocate == 1) : ?>
			<col width="<?php echo $this->jemsettings->locationwidth; ?>" class="jem_col_venue" />
		<?php endif; ?>
		<?php if ($this->jemsettings->showcity == 1) : ?>
			<col width="<?php echo $this->jemsettings->citywidth; ?>" class="jem_col_city" />
		<?php endif; ?>
		<?php if ($this->jemsettings->showstate == 1) : ?>
			<col width="<?php echo $this->jemsettings->statewidth; ?>" class="jem_col_state" />
		<?php endif; ?>
		<?php if ($this->jemsettings->showcat == 1) : ?>
			<col width="<?php echo $this->jemsettings->catfrowidth; ?>" class="jem_col_category" />
		<?php endif; ?>
		<?php if ($this->jemsettings->showatte == 1) : ?>
			<col width="<?php echo $this->jemsettings->attewidth; ?>" class="jem_col_attendees" />
		<?php endif; ?>
	</colgroup>

	<thead>
		<tr>
			<?php if ($this->jemsettings->showeventimage == 1) : ?>
				<th id="jem_eventimage" class="sectiontableheader" align="left"><?php echo JText::_('COM_JEM_TABLE_EVENTIMAGE'); ?></th>
			<?php endif; ?>
				<th id="jem_date" class="sectiontableheader" align="left"><?php echo JHtml::_('grid.sort', 'COM_JEM_TABLE_DATE', 'a.dates', $this->lists['order_Dir'], $this->lists['order']); ?></th>
			<?php if ($this->jemsettings->showtitle == 1) : ?>
				<th id="jem_title" class="sectiontableheader" align="left"><?php echo JHtml::_('grid.sort', 'COM_JEM_TABLE_TITLE', 'a.title', $this->lists['order_Dir'], $this->lists['order']); ?></th>
			<?php endif; ?>
			<?php if ($this->jemsettings->showlocate == 1) : ?>
				<th id="jem_location" class="sectiontableheader" align="left"><?php echo JHtml::_('grid.sort', 'COM_JEM_TABLE_LOCATION', 'l.venue', $this->lists['order_Dir'], $this->lists['order']); ?></th>
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
			<?php if ($this->jemsettings->showatte == 1) : ?>
				<th id="jem_attendees" class="sectiontableheader" align="center"><?php echo JText::_('COM_JEM_TABLE_ATTENDEES'); ?></th>
			<?php endif; ?>
		</tr>
	</thead>

	<tbody>
	<?php if ($this->noevents == 1) : ?>
		<tr align="center"><td colspan="20"><?php echo JText::_('COM_JEM_NO_EVENTS'); ?></td></tr>
	<?php else : ?>
		<?php $this->rows = $this->getRows(); ?>
		<?php foreach ($this->rows as $row) : ?>
        <?php if ($row->featured != 0 ) :   ?>
            <tr class="featured featured<?php echo $row->id.$this->params->get('pageclass_sfx'); ?>" itemscope="itemscope" itemtype="http://schema.org/Event" >
        <?php else : ?>
            <tr class="sectiontableentry<?php echo ($row->odd +1) . $this->params->get('pageclass_sfx'); ?>" itemscope="itemscope" itemtype="http://schema.org/Event" >
        <?php endif; ?>
				<?php if ($this->jemsettings->showeventimage == 1) : ?>
					<td headers="jem_eventimage" align="left" valign="top">
						<?php if ($row->datimage) : ?>
							<?php
							$dimage = JEMImage::flyercreator($row->datimage, 'event');
							echo JEMOutput::flyer($row, $dimage, 'event');
							?>
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

				<?php if ($this->jemsettings->showlocate == 1) : ?>
					<td headers="jem_location" align="left" valign="top">
						<?php if ($this->jemsettings->showlinkvenue == 1) : ?>
							<?php echo $row->locid != 0 ? "<a href='".JRoute::_(JEMHelperRoute::getVenueRoute($row->venueslug))."'>".$this->escape($row->venue)."</a>" : '-'; ?>
						<?php else : ?>
							<?php echo $row->locid ? $this->escape($row->venue) : '-'; ?>
						<?php endif; ?>
					</td>
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

				<?php if ($this->jemsettings->showatte == 1) : ?>
					<td headers="jem_attendees" align="left" valign="top">
						<?php echo $row->regCount ? $this->escape($row->regCount) : '-'; ?></td>
				<?php endif; ?>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
</table>