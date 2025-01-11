#!/bin/bash

# Variables
GIT_REPO="your-git-repo-url"  # Replace with your Git repository URL
BRANCH_NAME="main"            # Replace with your branch name
JENKINS_JOB_URL="http://your-jenkins-server/job/your-job-name/build"  # Replace with your Jenkins job URL
JENKINS_AUTH_TOKEN="your-jenkins-auth-token"  # Replace with your Jenkins authentication token
SERVER_SSH="user@your-server-ip"  # Replace with your server SSH details
APP_DIR="/var/www/html"  # Replace with your application directory on the server

# Step 4: Develop and commit changes locally (manual step, not automated)

# Step 5: Push code to the remote Git repository
echo "Pushing code to Git repository..."
git add .
git commit -m "Automated commit: $(date +'%Y-%m-%d %H:%M:%S')"
git push origin $BRANCH_NAME

# Step 6: Trigger Jenkins job to pull, compile, run, and deploy
echo "Triggering Jenkins job..."
curl -X POST "$JENKINS_JOB_URL" --user "your-jenkins-username:your-jenkins-password" --data-urlencode "token=$JENKINS_AUTH_TOKEN"

# Optional: SSH into the server and verify deployment
echo "Verifying deployment on the server..."
ssh $SERVER_SSH "cd $APP_DIR && git pull origin $BRANCH_NAME && sudo systemctl restart apache2"

echo "Automation complete!"