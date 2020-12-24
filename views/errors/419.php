<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_view('include.head', ['title' => '419 Authentication invalid', 'noindex' => true]); ?>
</head>

<body>

    <div class="uk-container">
            <div class="uk-section-large">
                <div class="uk-container uk-container-small">
                    <div uk-grid class="uk-grid-collapse uk-grid-match uk-child-width-1">
                        <div></div>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <h1 class="uk-heading-primary uk-text-middle">419</h1>
                                Authentication invalid
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-primary uk-card-body">
                                <h3 class="uk-card-title">What is this page</h3>
                                <p>
                                    It is used as an alternative to 401 Unauthorized in order to differentiate from otherwise authenticated clients being denied access to specific server resources..
                                </p>
                            </div>
                            <button type="button" class="uk-button uk-button-primary" onclick="history.back()">Go back</button>
                        </div>
                    </div>
                </div>            
        </div>
    </div>