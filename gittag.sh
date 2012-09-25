#!/bin/bash -eu

#Script add a tag to all reporistories with a current date

# SSH-avain muistiin
#ssh-add

DATE=$(date +%Y-%m-%d)

git tag -f $DATE
git push origin $DATE:refs/tags/$DATE

echo "Repository is now tagged with: $DATE"
echo '<(^__^)>'