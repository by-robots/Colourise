# Colourise

Takes black and white photos and colourises them. Magic.

## Dependencies
- https://github.com/satoshiiizuka/siggraph2016_colorization
- http://torch.ch/docs/getting-started.html

The Colorization dependency is included as a submodule. Torch is not and will
need to be installed seperately.

## Running Locally
Install dependencies above.

```
chmod a+x start.sh
chmod a+x process.sh
```

Set both `.sh` files to open automatically in Terminal.

Install a local MySQL instance.

Double click `start.sh` to begin the web server.

Double click `process.sh` to process images.
