<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_view('include.head', ['title' => 'Delete', 'noindex' => true]); ?>
</head>

<body>

    <div class="uk-container">
        <div class="uk-section-large">
            <div class="uk-container uk-container-small">
                <div uk-grid class="uk-grid-collapse uk-grid-match uk-width-1-2@s uk-margin-auto">
                    <div></div>
                    <div>
                        <div class="uk-card uk-card-default uk-text-center uk-card-body">
                        <?php echo ($sts)?'Deleted Successfully':'Unable to deleted' ?>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="uk-button uk-button-primary" onclick="history.back()">Go back</button>
                    </div>
                </div>
            </div>            
        </div>
    </div>