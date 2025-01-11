#!/bin/bash

# Variables
GIT_REPO="https://github.com/NadeenMK/Dictionary.git"  
BRANCH_NAME="main"  
JENKINS_JOB_URL="http://localhost:8080/job/Dictionary/build"  # Replace with your Jenkins job URL
JENKINS_AUTH_TOKEN="your-jenkins-auth-token"  # Replace with your Jenkins authentication token
SERVER_SSH="root@172.18.49.151" 
APP_DIR="/var/www/html/Dictionary"  # Corrected path to application directory

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
curl -X POST "$JENKINS_JOB_URL" --user "omaima shtiwe:$JENKINS_AUTH_TOKEN" --data-urlencode "token=$JENKINS_AUTH_TOKEN"
if [ $? -ne 0 ]; then
    echo "Error: Failed to trigger Jenkins job."
    exit 1
fi

# Optional: SSH into the server and verify deployment
echo "Verifying deployment on the server..."
ssh $SERVER_SSH "cd $APP_DIR && git pull origin $BRANCH_NAME && sudo systemctl restart apache2"
if [ $? -ne 0 ]; then
    echo "Error: Failed to deploy or restart Apache server."
    exit 1
fi

echo "Automation complete!"
