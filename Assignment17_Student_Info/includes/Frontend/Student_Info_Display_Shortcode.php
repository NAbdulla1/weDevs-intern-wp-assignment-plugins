<?php


namespace A17_STUDENT_INFO\Frontend;


use A17_STUDENT_INFO\DB;

class Student_Info_Display_Shortcode {
	const tag = 'a17_si_student_info_display_shortcode';

	public function __construct() {
		add_shortcode( self::tag, [ $this, 'display_information' ] );
	}

	/**
	 * @return false|string
	 */
	public function display_information() {
		$page     = 1;
		$per_page = 2;
		if ( ! empty( $_GET['a17_si_page'] ) ) {
			$page = max( 1, (int) $_GET['a17_si_page'] );
		}
		if ( ! empty( $_GET['a17_si_per_page'] ) ) {
			$per_page = max( 1, (int) $_GET['a17_si_per_page'] );
		}

		$total_pages = (int) ( ( DB::get_total() + $per_page - 1 ) / $per_page );

		$students     = DB::get_students( $page, $per_page );
		$metaTableObj = 'a17_si_student';//must be same as the $object_name in create_db_table function in Installer.php
		global $wp;
		$page_url = home_url( $wp->request );
		$nxt      = $page + 1;
		$prv      = $page - 1;
		ob_start();
		?>
		<?php if ( count( $students ) == 0 ) {
			echo "<div>No Student Found</div>";
		} else {
			?>
            <table>
                <tr>
					<?php foreach ( Student_Input_Shortcode::fields as $fieldName => $field_info ) {
						if ( $fieldName === 'a17_si_registration' ) {
							continue;
						}
						?>
                        <th><?php echo trim( $field_info[1], '*' ) ?></th>
						<?php
					} ?>
                </tr>
				<?php
				foreach ( $students as $student ) {
					?>
                    <tr>
                        <td><?php echo $student['first_name'] ?></td>
                        <td><?php echo $student['last_name'] ?></td>
                        <td><?php echo $student['class'] ?></td>
                        <td><?php echo $student['roll_no'] ?></td>
                        <td><?php echo get_metadata( $metaTableObj, $student['id'], 'a17_si_ben', true ) ?></td>
                        <td><?php echo get_metadata( $metaTableObj, $student['id'], 'a17_si_eng', true ) ?></td>
                        <td><?php echo get_metadata( $metaTableObj, $student['id'], 'a17_si_math', true ) ?></td>
                    </tr>
					<?php
				}
				?>
            </table>

            <form action="" method="get" id="a17_form_pagination">
                <table class="form-table">
                    <tr>
                        <td>
                            <label style="padding: 2px; width: 40%" for="a17_si_page">Page:</label>
                            <input style="padding: 2px; width: 50%" type="number" name="a17_si_page" id="a17_si_page"
                                   value='<?php echo $page ?>'/>
                        </td>
                        <td>
                            <label style=" padding: 2px; width: 40%" for="a17_si_per_page">Per Page:</label>
                            <input style="padding:2px; width: 50%" type="number" name="a17_si_per_page"
                                   id="a17_si_per_page"
                                   value='<?php echo $per_page ?>'/>
                        </td>
                        <td colspan="2" style="text-align: right">
                            <button style="padding: 2px" type="submit">Apply</button>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right" colspan="3">
							<?php if ( $page != 1 ) {
								?>
                                <a type="submit"
                                   href="<?php echo $page_url . "?a17_si_page=$prv&a17_si_per_page=$per_page" ?>">&lt;
                                    Previous Page
                                </a>
								<?php
							} ?>

                            <span style="width: 20px"></span>
							<?php if ( $page < $total_pages ) {
								?>
                                <a type="submit"
                                   href="<?php echo $page_url . "?a17_si_page=$nxt&a17_si_per_page=$per_page" ?>">Next
                                    Page &gt;
                                </a>
								<?php
							} ?>
                        </td>
                    </tr>
                </table>
            </form>
			<?php
		} ?>

		<?php

		return ob_get_clean();
	}
}
