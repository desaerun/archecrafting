<style type="text/css">
.body {
	font-size:100%;
}
.container {
	display:inline-block;
	border:1px solid black;
}
.item_container {
    background: #aaa;
    /* margin: 2px; */
    padding: 2px 3px;
    border: 1px solid black;
    display: flex;
    flex-flow: column;
    justify-content: center;
    align-items: center;
	position:relative;
}
.recipe_container {
    display: flex;
    background: green;
    margin-top: auto;
}
.item_amount {
	font-weight:bold;
	font-family:Verdana;
	font-size:small;
}
.item_box {
    width: 32px;
    height: 32px;
    border: 3px solid black;
    overflow: hidden;
    margin: 3px;
    display: flex;
    align-items: center;
}
.item_label {
    display: flex;
    justify-content: center;
    flex-flow: nowrap;
    align-items: center;
    width: 100%;
    height: 100%;
	min-height: 54px;
}
.add_button {
	font-family: Helvetica;
	font-weight: bold;
    border: 1px solid black;
    position: absolute;
    right: 1px;
    top: 1px;
    line-height: 1em;
    width: 1em;
    text-align: center;
    background: #54cc84;
	cursor:pointer;
}
.add_button:hover {
	background: #2f9e5c;
}
</style>
<div class="container">
	<div class="item_container">
		<div class="add_button">&plus;</div>
		<div class="item_label">
			<div class="item_amount">1x</div>
			<div class="item_box">Farm Cart</div>
		</div>
		<div class="recipe_container">
			<div class="item_container">
				<div class="add_button">&plus;</div>
				<div class="item_label">
					<div class="item_amount">1x</div>
					<div class="item_box">Farm Cart Design</div>
				</div>
			</div>
			<div class="item_container">
				<div class="add_button">&plus;</div>
				<div class="item_label">
					<div class="item_amount">4x</div>
					<div class="item_box">Cart Wheel</div>
				</div>
				<div class="recipe_container">
					<div class="item_container">
						<div class="add_button">&plus;</div>
						<div class="item_label">
							<div class="item_amount">40x</div>
							<div class="item_box">Lumber</div>
						</div>
						<div class="recipe_container">
							<div class="item_container">
								<div class="add_button">&plus;</div>
								<div class="item_label">
									<div class="item_amount">120x</div>
									<div class="item_box">Log</div>
								</div>
							</div>
						</div>
					</div>
					<div class="item_container">
						<div class="add_button">&plus;</div>
						<div class="item_label">
							<div class="item_amount">40x</div>
							<div class="item_box">Iron Ingot</div>
						</div>
						<div class="recipe_container">
							<div class="item_container">
								<div class="add_button">&plus;</div>
								<div class="item_label">
									<div class="item_amount">120x</div>
									<div class="item_box">Iron Ore</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="item_container">
				<div class="add_button">&plus;</div>
				<div class="item_label">
					<div class="item_amount">1x</div>
					<div class="item_box">Cart Engine</div>
				</div>
				<div class="recipe_container">
					<div class="item_container">
						<div class="add_button">&plus;</div>
						<div class="item_label">
							<div class="item_amount">2x</div>
							<div class="item_box">Fine Lumber</div>
						</div>
						<div class="recipe_container">
							<div class="item_container">
								<div class="add_button">&plus;</div>
								<div class="item_label">
									<div class="item_amount">20x</div>
									<div class="item_box">Lumber</div>
								</div>
								<div class="recipe_container">
									<div class="item_container">
										<div class="add_button">&plus;</div>
										<div class="item_label">
											<div class="item_amount">60x</div>
											<div class="item_box">Log</div>
										</div>
									</div>
								</div>
							</div>
							<div class="item_container">
								<div class="add_button">&plus;</div>
								<div class="item_label">
									<div class="item_amount">2x</div>
									<div class="item_box">Small Seed Oil</div>
								</div>
								<div class="recipe_container">
									<div class="item_container">
										<div class="add_button">&plus;</div>
										<div class="item_label">
											<div class="item_amount">6x</div>
											<div class="item_box">Onyx Archeum</div>
										</div>
									</div>
									<div class="item_container">
										<div class="add_button">&plus;</div>
										<div class="item_label">
											<div class="item_amount">40x</div>
											<div class="item_box">Corn</div>
										</div>
									</div>
									<div class="item_container">
										<div class="add_button">&plus;</div>
										<div class="item_label">
											<div class="item_amount">40x</div>
											<div class="item_box">Rice</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="item_container">
						<div class="item_label">
							<div class="item_amount">10x</div>
							<div class="item_box">Silver Ingot</div>
							<div class="add_button">&plus;</div>
						</div>
						<div class="recipe_container">
							<div class="item_container">
								<div class="item_label">
									<div class="item_amount">30x</div>
									<div class="item_box">Silver Ore</div>
									<div class="add_button">&plus;</div>
								</div>
							</div>
						</div>
					</div>
					<div class="item_container">
						<div class="add_button">&plus;</div>
						<div class="item_label">
							<div class="item_amount">1x</div>
							<div class="item_box">Archeum Ingot</div>
							
						</div>
						<div class="recipe_container">
							<div class="item_container">
								<div class="add_button">&plus;</div>
								<div class="item_label">
									<div class="item_amount">3x</div>
									<div class="item_box">Archeum Ore</div>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>