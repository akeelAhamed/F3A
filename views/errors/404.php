<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_view('include.head', ['title' => '404 Not found', 'noindex' => true]); ?>
</head>

<body>

    <div class="uk-container">
            <div class="uk-section-large">
                <div class="uk-container uk-container-small">
                    <div uk-grid class="uk-grid-collapse uk-grid-match uk-child-width-1">
                        <div></div>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <h1 class="uk-heading-primary uk-text-middle">404</h1>
                                Page not found
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-primary uk-card-body">
                                <h3 class="uk-card-title">What is this page</h3>
                                <p>
                                    Sometimes things go wrong and you get lost, the content you
                                    are trying to see does not exist or is no longer visible. Please
                                    contact the administrator if you belive it's an error.
                                </p>
                            </div>
                            <button type="button" class="uk-button uk-button-primary" onclick="history.back()">Go back</button>
                        </div>
                    </div>
                </div>
        </div>
    </div>