FROM ubuntu:14.04

RUN apt-get update 
RUN apt-get install python3-pip -y
RUN pip3 install flask

ENV HOME /home

COPY flaskapp /home/flaskapp

EXPOSE 5000

STOPSIGNAL SIGTERM

WORKDIR /home/flaskapp

ENTRYPOINT ["python3"]

CMD ["app.py"]
