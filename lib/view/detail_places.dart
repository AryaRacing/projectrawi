import 'package:flutter/material.dart';
import 'package:proyek_akhir/model/placeBE.dart';
import 'package:proyek_akhir/view/view_map.dart.dart';

class PlaceDetailScreen extends StatelessWidget {
  const PlaceDetailScreen({super.key, required this.place});

  final Place place;

  String get locationImage {
    final lat = place.location.latitude;
    final long = place.location.longitude;
    return 'https://maps.googleapis.com/maps/api/staticmap?center$lat,$long=&zoom=15&size=600x300&maptype=roadmap&markers=color:red%7Clabel:A%7C$lat,$long&key=AIzaSyCwoOi31-5NWc5yxS_qP0M6HzPvV0uFpR4';
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(place.title),
      ),
      body: Stack(
        children: [
          Image.file(
            place.image,
            width: double.infinity,
            height: double.infinity,
          ),
          Positioned(
            bottom: 10,
            left: 0,
            right: 0,
            child: Column(
              children: [
                GestureDetector(
                  onDoubleTap: () {
                    Navigator.of(context).push(
                      MaterialPageRoute(
                          builder: (ctx) => ScreenMap(
                                location: place.location,
                                isSelecting: false,
                              )),
                    );
                  },
                  child: CircleAvatar(
                    radius: 50,
                    backgroundImage: NetworkImage(locationImage),
                  ),
                ),
              ],
            ),
          ),
          Positioned(
              top: 10,
              left: 0,
              right: 0,
              child: Column(
                children: [
                  Container(
                    alignment: Alignment.center,
                    padding: const EdgeInsets.symmetric(
                        horizontal: 25, vertical: 15),
                    decoration: const BoxDecoration(
                      gradient: LinearGradient(
                        colors: [
                          Colors.transparent,
                          Colors.transparent,
                        ],
                        begin: Alignment.topCenter,
                        end: Alignment.bottomCenter,
                      ),
                    ),
                    child: Text(
                      place.location.address,
                      textAlign: TextAlign.left,
                      style: Theme.of(context).textTheme.bodyMedium!.copyWith(
                            color: Theme.of(context).colorScheme.onBackground,
                          ),
                    ),
                  )
                ],
              ))
        ],
      ),
    );
  }
}
