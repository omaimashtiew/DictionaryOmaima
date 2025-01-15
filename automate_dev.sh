#!/bin/bash

# Variables
GIT_REPO="https://github.com/NadeenMK/Dictionary.git"  
BRANCH_NAME="main"  
JENKINS_JOB_URL="http://localhost:8080/job/Dictionary/build"  # Replace with your Jenkins job URL
JENKINS_AUTH_TOKEN="11094f66ea18df9e634c661c1f0d31f354"  # Replace with your Jenkins authentication token
SERVER_SSH="root@dictionary_www_1"
APP_DIR="/var/www/html"  # Corrected path to application directory

# Step 4: Develop and commit changes locally (manual step, not automated)

# Step 5: Push code to the remote Git repository
echo "Pushing code to Git repository..."
git add .
git commit -m "Automated commit: $(date +'%Y-%m-%d %H:%M:%S')"
git push origin $BRANCH_NAME
if [ $? -ne 0 ]; then
    echo "Error: Failed to push code to Git repository."
    exit 1
fi

# Step 6: Trigger Jenkins job to pull, compile, run, and deploy
echo "Triggering Jenkins job..."
curl -X POST "$JENKINS_JOB_URL/build?token=$JENKINS_AUTH_TOKEN" --user "omaima:$JENKINS_AUTH_TOKEN"
if [ $? -ne 0 ]; then
    echo "Error: Failed to trigger Jenkins job."
    exit 1
fi

# Optional: Verify deployment inside the Docker container
echo "Verifying deployment inside the Docker container..."
docker exec dictionary_www_1 bash -c "cd $APP_DIR  && service apache2 restart"
if [ $? -ne 0 ]; then
    echo "Error: Failed to deploy or restart Apache server."
    exit 1
fi

echo "Automation complete!"
