<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... -->
    <script type="text/javascript" src="https://unpkg.com/knockout/build/output/knockout-latest.js"></script>

    <!-- SurveyJS resources -->
    <link  href="https://unpkg.com/survey-core/defaultV2.min.css" type="text/css" rel="stylesheet">
    <script src="https://unpkg.com/survey-core/survey.core.min.js"></script>
    <script src="https://unpkg.com/survey-knockout-ui/survey-knockout-ui.min.js"></script>
    
    <!-- Survey Creator resources -->
    <link  href="https://unpkg.com/survey-creator-core/survey-creator-core.min.css" type="text/css" rel="stylesheet">
    <script src="https://unpkg.com/survey-creator-core/survey-creator-core.min.js"></script>
    <script src="https://unpkg.com/survey-creator-knockout/survey-creator-knockout.min.js"></script>
    <!-- ... -->
</head>
<body>

    <div id="surveyCreator" style="height: 100vh;"></div>

    <script>
        const creatorOptions = {
            showLogicTab: true,
            isAutoSave: true
        };

        const creator = new SurveyCreator.SurveyCreator(creatorOptions);
        document.addEventListener("DOMContentLoaded", function() {
            creator.render("surveyCreator");
        });

        creator.saveSurveyFunc = (saveNo, callback) => {
            // If you use localStorage:
            window.localStorage.setItem("survey-json", creator.text);
            callback(saveNo, true);

            // If you use a web service:
            saveSurveyJson(
                "https://your-web-service.com/",
                creator.JSON,
                saveNo,
                callback
            );
        };

        // If you use a web service:
        function saveSurveyJson(url, json, saveNo, callback) {
            const request = new XMLHttpRequest();
            request.open('POST', url);
            request.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            request.addEventListener('load', () => {
                callback(saveNo, true);
            });
            request.addEventListener('error', () => {
                callback(saveNo, false);
            });
            request.send(JSON.stringify(json));
        }

        const defaultJson = {
            pages: [{
                name: "Name",
                elements: [{
                    name: "FirstName",
                    title: "Enter your first name:",
                    type: "text"
                }, {
                    name: "LastName",
                    title: "Enter your last name:",
                    type: "text"
                }]
            }]
        };

        creator.text = window.localStorage.getItem("survey-json") || JSON.stringify(defaultJson);
        
    </script>
</body>
</html>