public class AnimalUtil {
    enum AnimalType {Bird, Dog, Cat, Elephant, Rhino, Lion, Squirrel}

    static class Animal {

        AnimalType animalType;
    }

    enum RoomType {Hall, Bedroom, Bathroom, Balcony}

    static class Room {
        int capacity;
        RoomType roomType;
    }

    static void arrangeAnimalsAmongRooms(Animal[] animals, Room[] rooms) {
        for (int i = 0; i < animals.length; i++) {
            if (animals[i].animalType == AnimalType.Bird) {
                for (int j = 0; j < rooms.length; j++) {
                    if (rooms[j].roomType == RoomType.Hall && rooms[j].capacity != 0) {
                        rooms[j].capacity -= 0.25;
                    }
                }
            } else if (animals[i].animalType == AnimalType.Dog) {
                boolean foundRoom = false;
                for (int j = 0; j < rooms.length; j++) {
                    if (rooms[j].roomType == RoomType.Bedroom && rooms[j].capacity != 0) {
                        rooms[j].capacity -= 0.4;
                        break;
                    }
                }
                if (!foundRoom) {
                    throw new IllegalArgumentException("Dog(s) can be arranged");
                }
            } else if (animals[i].animalType == AnimalType.Elephant) {
                for (int j = 0; j < rooms.length; j++) {
                    if (rooms[j].roomType == RoomType.Balcony && rooms[j].capacity != 0) {
                        rooms[j].capacity -= 0.6;
                        System.out.println("A new elephant just arrived");
                    }
                }
            } else if (animals[i].animalType == AnimalType.Rhino) {
                boolean foundRoom = false;
                for (int j = 0; j < rooms.length; j++) {
                    if (rooms[j].roomType == RoomType.Bedroom && rooms[j].capacity != 0) {
                        rooms[j].capacity -= 0.6;
                        foundRoom = true;
                        break;
                    }
                }
                if (!foundRoom) {
                    throw new IllegalArgumentException("Rhinos(s) can be arranged");
                }
            }
        }
    }

}
