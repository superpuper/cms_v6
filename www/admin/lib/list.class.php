<?
require ("lib/tablerows.class.php");
require ("lib/toolbar.class.php");

class CList extends TableRows {
	
	// TODO the $bookmark argument is not in use here - this is to override TableRows::render($bookmark = NULL) with no warning for now
	function render($bookmark = NULL) {
		if ($this->init()) {
	
			foreach($this->toolbars as $toolbar) {
				$toolbar->render();
			}
			unset($toolbar); ?>
	
		<?	if ($this->rec_count != 0) { ?>
				<div class="cm-content">
					<div class="cm-content-title">
						<span><?=$this->table_meta['title']?></span>
					</div>
				</div>
		<?	}
	
			if (isset($this->order)) {
				list($order_table_name, $order_field, $order_direction, $order_field_type) = explode('.', $this->order);
				$this->set_order($order_table_name, $order_field, $order_direction, $order_field_type);
			}
			parent::render();
		}
	}

	function make_main_toolbar(&$toolbar) {
		if ($this->table_meta['deletable']) { 
			$toolbar->add_button("edit.php?" . $_SERVER['QUERY_STRING'] . "&new=yes", "images/icons/page_white_add.png", $this->table_meta['title_addnew']);
			// "edit.php?type=" . $this->table . "&new=yes"
			// $_SERVER['QUERY_STRING'] to pass all GET parameters as is, the 'type' in 'list' is always the same as the $this->table
		}
	}

	function init() {
		if (isset($_GET['filter'])) {
			$this->set_sql_filter(mysqli_real_escape_string($this->conn, $_GET['filter']));
		}
		if (parent::init()) {
			$this->make_main_toolbar($this->toolbars['main'] = new Toolbar());
			return true;
		} else {
			return false;
		}
	}

	var $order;

} // class
?>