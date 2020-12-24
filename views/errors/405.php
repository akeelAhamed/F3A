<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_view('include.head', ['title' => '405 Method not allowed', 'noindex' => true]); ?>
</head>

<body>

    <div class="uk-container">
            <div class="uk-section-large">
                <div class="uk-container uk-container-small">
                    <div uk-grid class="uk-grid-collapse uk-grid-match uk-child-width-1">
                        <div></div>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <h1 class="uk-heading-primary uk-text-middle">405</h1>
                                Method not allowed
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-primary uk-card-body">
                                <h3 class="uk-card-title">What is this page</h3>
                                <p>
                                    Error is an HTTP response status code that indicates a web browser has requested access to one of your web pages and your web server received and recognized its HTTP method.
                                </p>
                            </div>
                            <button type="button" class="uk-button uk-button-primary" onclick="history.back()">Go back</button>
                        </div>
                    </div>
                </div>            
        </div>
    </div>