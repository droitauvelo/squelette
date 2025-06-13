SHELL:=/bin/bash

SPIP_VERSION=4.4
PLUGINS="yaml numerotation ancres_douces pays   \
        z-core compositions facteur abomailmans noie   \
        albums_3 spipr_dist"

.PHONY: run

install:
	# install spip
	./install-scripts/install-spip.sh ${SPIP_VERSION}
	./install-scripts/install-spip-plugins.sh ${PLUGINS}

	# fetch js
	cd squlettes/sources
	yarn install

run:
	echo "TODO - Merci de patienter un peu c'est pas encore codé :)"
