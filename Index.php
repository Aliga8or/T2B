<!--Page starts here-->

<?php
require_once("Header.php");

?>
				<div class='eList' >
					<form name="loginForm" method="POST" action="Index.php" >
						<table>
							<tr>
								<td>User</td> <td><input name="user" type="text" /></td>
							</tr>
							<tr>
								<td>Magic Words</td> <td><input name="pass" type="password" /></td>
							</tr>
							<tr>
								<td align='center' colspan='2' >
									<button type='submit' name='submit' value='submit' style='background-color:inherit; border:0; cursor:pointer;' >
										<img src='img/add-post.png' width='40' height='40' />
									</button>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>