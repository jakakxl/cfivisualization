import csv, time
from geopy import geocoders

g = geocoders.Google()
header = ['portal', 'issuer', 'location', 'status', 'goal', 'currently_raised', 'currency', 'latitude', 'longitude']

with open('Jan2013_formatted.csv', 'r') as csv_readfile, open('Jan2013_formatted_with_latitude.csv', 'wb') as csv_writefile:
    read_handler = csv.DictReader(csv_readfile)
    write_handler = csv.DictWriter(csv_writefile, header)
    write_handler.writeheader()

    for row in read_handler:
        try:
            place, (lat, lng) = g.geocode(row['location'])
            row['location'] = place
            row['latitude'] = lat
            row['longitude'] = lng
            write_handler.writerow(row)
        except Exception as e:
            print e
            write_handler.writerow(row)

        time.sleep(1)