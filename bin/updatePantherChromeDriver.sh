#!/usr/bin/env bash
# ensure that symfony/panther's chromeDriver matches installed chromium version
# this needs chromium and symfony/panther (in vendor folder) to be installed

mkdir -p vendor/symfony/panther/chromedriver-bin
cd vendor/symfony/panther/chromedriver-bin

chromiumVersion=$(chromium --product-version 2>&1;);
chromiumBrowserVersion=$(chromium-browser --product-version 2>&1;);
googleChromeVersion=$(google-chrome --product-version 2>&1;);
if [[ ${chromiumVersion} == *"."*"."* ]]; then
  chromiumVersion="$( cut -d '.' -f 1 <<< "$chromiumVersion" )";
  echo "Found chromium version ${chromiumVersion}";
  chromeDriverVersion="_${chromiumVersion}"
elif [[ ${chromiumBrowserVersion} == *"."*"."* ]]; then
  chromiumBrowserVersion="$( cut -d '.' -f 1 <<< "$chromiumBrowserVersion" )";
  echo "Found chromium-browser version ${chromiumBrowserVersion}";
  chromeDriverVersion="_${chromiumBrowserVersion}"
elif [[ ${googleChromeVersion} == *"."*"."* ]]; then
  googleChromeVersion="$( cut -d '.' -f 1 <<< "$googleChromeVersion" )";
  echo "Found google-chrome version ${googleChromeVersion}";
  chromeDriverVersion="_${googleChromeVersion}"
else
  "No google-chrome, chromium-browser or chromium found. Using latest release..."
  chromeDriverVersion=""
fi

chromeDriver=$(curl -s https://chromedriver.storage.googleapis.com/LATEST_RELEASE${chromeDriverVersion});
echo "Downloading ChromeDriver version ${chromeDriver} from https://chromedriver.storage.googleapis.com/LATEST_RELEASE${chromeDriverVersion} ..."

declare -a binaries=("chromedriver_linux64" "chromedriver_mac64" "chromedriver_win32")
for name in "${binaries[@]}"
do
   curl -s https://chromedriver.storage.googleapis.com/${chromeDriver}/${name}.zip -O
   unzip -q -o ${name}.zip
   rm ${name}.zip
   if [[ -f "chromedriver" ]]; then
      mv chromedriver ${name}
   fi
done

curl -s https://chromedriver.storage.googleapis.com/${chromeDriver}/notes.txt -O
echo "Done."
