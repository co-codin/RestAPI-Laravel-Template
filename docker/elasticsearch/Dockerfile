FROM docker.elastic.co/elasticsearch/elasticsearch:7.10.1
RUN /usr/share/elasticsearch/bin/elasticsearch-plugin install analysis-icu
RUN /usr/share/elasticsearch/bin/elasticsearch-plugin install analysis-phonetic

EXPOSE 9200 9300
