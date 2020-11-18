#!/usr/bin/env bash

set -e
set -x

CURRENT_BRANCH="0.x"

function split()
{
#    SHA1=`./bin/splitsh-lite --prefix=$1`
#    git push $2 "$SHA1:refs/heads/$CURRENT_BRANCH" -f
     git subtree push --prefix=$1 $2 $CURRENT_BRANCH
}

function remote()
{
    git remote add $1 $2 || true
}

git pull origin $CURRENT_BRANCH

remote auth git@github.com:fansheng0594/framework-auth.git
remote contracts git@github.com:fansheng0594/framework-contracts.git
remote container git@github.com:fansheng0594/framework-container.git
remote support git@github.com:fansheng0594/framework-support.git
remote filesystem git@github.com:fansheng0594/framework-filesystem.git
remote events git@github.com:fansheng0594/framework-events.git

split 'src/Fantastic/Auth' auth
split 'src/Fantastic/Contracts' contracts
split 'src/Fantastic/Container' container
split 'src/Fantastic/Support' support
split 'src/Fantastic/Filesystem' filesystem
split 'src/Fantastic/Events' events
