#! /bin/bash

pluginsToBeRemoved=()

baseBranch="master"

for str in ${pluginsToBeRemoved[@]}; do
  git checkout master && git checkout -b "remove/$str" && rm -r plugins/$str && git add plugins/$str && git commit -m "chore: Remove $str plugin" && git push origin remove/$str && gh pr create --base $baseBranch --head remove/$str --title "Remove $str plugin" --body ""
done