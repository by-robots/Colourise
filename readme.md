# Colourise

Takes black and white photos and colourises them. Magic.

## Dependencies
- https://github.com/satoshiiizuka/siggraph2016_colorization
- http://torch.ch/docs/getting-started.html

The Colorization dependency is included as a submodule. Torch is not and will
need to be installed seperately.

## Local Installation
1. Clone this repository
2. `chmod u+x install.sh`
3. `./install.sh`
4. Increase php.ini's file upload limits:

```
max_execution_time = 0
max_file_uploads = 1000000
max_input_time = -1
memory_limit = -1
post_max_size = 0
upload_max_filesize = 8G
```

## Local Execution
- Double click `start.sh` to begin the web server.
- Double click `process.sh` to process images.
