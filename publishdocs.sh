./vendor/bin/phpdoc
git clone --branch=gh-pages --single-branch git@github.com:victorhaggqvist/sl-api-client-php.git ghpages
pushd ghpages
rm -rf *
popd
cp -r docs/* ghpages
pushd ghpages
git add .
git commit -m "update api docs"
git push --force
popd
rm -rf ghpages
