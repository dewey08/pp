const video = document.getElementById('video')

// Promise.all([
//   faceapi.nets.tinyFaceDetector.loadFromUri('/pkbackoffice/public/models'),
//   faceapi.nets.faceLandmark68Net.loadFromUri('/pkbackoffice/public/models'),
//   faceapi.nets.faceRecognitionNet.loadFromUri('/pkbackoffice/public/models'),
//   faceapi.nets.faceExpressionNet.loadFromUri('/pkbackoffice/public/models')
// ]).then(startVideo)

Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('./models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('./models'),
    faceapi.nets.faceRecognitionNet.loadFromUri('./models'),
    faceapi.nets.faceExpressionNet.loadFromUri('./models')
  ]).then(startVideo)

function startVideo() {
//     navigator.getUserMedia(
//     {
//         audio: true,
//         video: { width: 1280, height: 720}
//     },
//     stream => video.srcObject = stream,
//     err => console.error(err)
//   )

    navigator.getUserMedia =
    navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia;

    if (navigator.getUserMedia) {
        navigator.getUserMedia(
          { audio: true, video: { width: 920, height: 860 } },
          (stream) => {
            const video = document.querySelector("video");
            video.srcObject = stream;
            video.onloadedmetadata = (e) => {
              video.play();
            };
          },
          (err) => {
            console.error(`The following error occurred: ${err.name}`);
          },
        );
      } else {
        console.log("getUserMedia not supported");
      }


    // Prefer camera resolution nearest to 1280x720.
    // const constraints = {
    //     audio: true,
    //     video: { width: 1280, height: 720 },
    // };

    // navigator.mediaDevices
    // .getUserMedia(constraints)
    // .then((mediaStream) => {
    //     const video = document.querySelector("video");
    //     video.srcObject = mediaStream;
    //     video.onloadedmetadata = () => {
    //     video.play();
    //     };
    // })
    // .catch((err) => {
    //     // always check for errors at the end.
    //     console.error(`${err.name}: ${err.message}`);
    // });

}

video.addEventListener('play', () => {
  const canvas = faceapi.createCanvasFromMedia(video)
  document.body.append(canvas)
  const displaySize = { width: video.width, height: video.height }
  faceapi.matchDimensions(canvas, displaySize)
  setInterval(async () => {
    const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
    const resizedDetections = faceapi.resizeResults(detections, displaySize)
    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
    faceapi.draw.drawDetections(canvas, resizedDetections)
    faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)
    faceapi.draw.drawFaceExpressions(canvas, resizedDetections)
  }, 100)
})
