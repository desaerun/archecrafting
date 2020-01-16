<head>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <style type="text/css">
        .form_title {
        }

        .form_contents_wrapper {
        }

        .form_label {
        }

        .form_inputs {
        }

        .form_inputs input, select {
        }

        .reagents_wrapper {
        }

        .reagent_box {
        }

        .reagent_amount {
        }

        .reagent_name {
        }

        .add_button {
        }

        .submit_button {
        }
    </style>
</head>
<body>
<form action="#" method="POST">
    <div class="form_wrapper">
        <div class="form_title">Add Craft</div>
        <div class="form_contents_wrapper">

            <div class="form_label">Crafted Item:</div>
            <div class="form_inputs">
                <label for="parent_item">Crafted Item:</label>
                <input type="text" name="amount" size="2"/>
                <label for="amount">x</label>
                <input type="text" name="parent_item" size="20"/>
            </div>

            <div class="form_label">Craft Name:</div>
            <div class="form_inputs">
                <input type="text" name="craft_name" size="20"/>
            </div>

            <div class="form_label">Labor Cost:</div>
            <div class="form_inputs">
                <input type="text" name="labor" size="4"/>
            </div>

            <div class="form_label">Reagents</div>
            <div class="form_inputs">
                <div class="reagents_wrapper">
                    <?php
                    // loop through and display box for current reagents attached to craft
                    ?>
                    <div class="reagent_box" id="item_34">
                        <div class="delete_reag_button">X</div>
                        <span class="reagent_amount">2x</span>
                        <span class="reagent_name">Fine Lumber</span>
                    </div>
                    <div class="reagent_box" id="item_29">
                        <div class="delete_button">X</div>
                        <span class="reagent_amount">12x</span>
                        <span class="reagent_name">Small Seed Oil</span>
                    </div>

                    <div class="reagent_box">
                        <div class="add_reag_button">+</div>
                    </div>
                </div>
            </div>
            <div class="submit_button">Add</div>
        </div>
    </div>
</form>
</body>