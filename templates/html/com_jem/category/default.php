<?php
/**
 * @version 1.9.5
 * @package JEM
 * @copyright (C) 2013-2013 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;
JHtml::_('behavior.modal');
?>
<div id="jem" class="jem_category">
	<div class="buttons">
	<?php
	echo JEMOutput::submitbutton($this->dellink, $this->params);
	echo JEMOutput::archivebutton($this->params, $this->task, $this->category->slug);
	echo JEMOutput::mailbutton($this->category->slug, 'category', $this->params);
	echo JEMOutput::printbutton($this->print_link, $this->params);
	?>
</div>

<?php if ($this->params->def( 'show_page_title', 1 )) : ?>
	<h1 class='componentheading'>
		<?php echo $this->task == 'archive' ? $this->escape($this->category->catname.' - '.JText::_('COM_JEM_ARCHIVE')) : $this->escape($this->category->catname); ?>
	</h1>
<?php endif; ?>

<div class="floattext">
	<?php if ($this->jemsettings->discatheader) : ?>
		<div class="catimg">
		<?php 
		// flyer
		if (empty($this->category->image)) {
			$jemsettings = JEMHelper::config();
			$imgattribs['width'] = $jemsettings->imagewidth;
			$imgattribs['height'] = $jemsettings->imagehight;
			
			echo JHtml::_('image', 'com_jem/noimage.png', $this->category->catname, $imgattribs, true);
		}
		else {
			echo JEMOutput::flyer($this->category, $this->cimage, 'category');
		}
		?>
		</div>
	<?php endif; ?>

	<div class="description">
			<p><?php echo $this->description; ?></p>
		</div>
	</div>

	<!--subcategories-->
	<?php
	if (count($this->categories) && $this->category->id > 0) :
	// only show this part if subcategries are available	?>
	<?php echo $this->loadTemplate('subcategories'); ?>
	<?php endif; ?>

	<form action="<?php echo $this->action; ?>" method="post" id="adminForm">
	<!--table-->
<table class="eventtable" style="width:<?php echo $this->jemsettings->tablewidth; ?>;" summary="jem">
	<colgroup>
			<!--<col width="<?php //echo $this->jemsettings->datewidth; ?>" class="jem_col_date" />-->
		<?php if ($this->jemsettings->showtitle == 1) : ?>
			<col width="<?php echo $this->jemsettings->titlewidth; ?>" class="jem_col_title" />
		<?php endif; ?>
		<?php if ($this->jemsettings->showcity == 1) :	?>
			<col width="<?php echo $this->jemsettings->citywidth; ?>" class="jem_col_city" />
		<?php endif; ?>
		<?php if ($this->jemsettings->showstate == 1) :	?>
			<col width="<?php echo $this->jemsettings->statewidth; ?>" class="jem_col_state" />
		<?php endif; ?>
	</colgroup>

	<thead>
		<tr>
			<!--<th id="jem_date" class="sectiontableheader" align="left"><?php //echo JHtml::_('grid.sort', 'COM_JEM_TABLE_DATE', 'a.dates', $this->lists['order_Dir'], $this->lists['order']); ?></th>-->
			<?php if ($this->jemsettings->showtitle == 1) : ?>
			<th id="jem_title" class="sectiontableheader" align="left"><?php echo JHtml::_('grid.sort', 'COM_JEM_TABLE_TITLE', 'a.title', $this->lists['order_Dir'], $this->lists['order']); ?></th>
			<?php endif; ?>
			<?php if ($this->jemsettings->showcity == 1) : ?>
			<th id="jem_city" class="sectiontableheader" align="left"><?php echo JHtml::_('grid.sort', 'COM_JEM_TABLE_CITY', 'l.city', $this->lists['order_Dir'], $this->lists['order']); ?></th>
			<?php endif; ?>
			<?php if ($this->jemsettings->showstate == 1) : ?>
			<th id="jem_state" class="sectiontableheader" align="left"><?php echo JHtml::_('grid.sort', 'COM_JEM_TABLE_STATE', 'l.state', $this->lists['order_Dir'], $this->lists['order']); ?></th>
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

				<!---<td headers="jem_date" align="left">
					<?php
						//echo JEMOutput::formatShortDateTime($row->dates, $row->times,
						//	$row->enddates, $row->endtimes);
						//echo JEMOutput::formatSchemaOrgDateTime($row->dates, $row->times,
						//	$row->enddates, $row->endtimes);
					?>
				</td>-->

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

			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
</table>	<input type="hidden" name="option" value="com_jem" /> 
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" /> 
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" /> 
	<input type="hidden" name="view" value="category" /> 
	<input type="hidden" name="task" value="<?php echo $this->task; ?>" /> 
	<input type="hidden" name="id" value="<?php echo $this->category->id; ?>" />
	</form>

	<!--pagination-->
	<div class="pagination">
	<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<!-- iCal -->
	<div id="iCal" class="iCal">
	<?php echo JEMOutput::icalbutton($this->category->id, 'category'); ?>
	</div>
	<!-- copyright -->
	<div class="copyright">
	<?php echo JEMOutput::footer( ); ?>
</div>
</div>